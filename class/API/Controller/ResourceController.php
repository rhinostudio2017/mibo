<?php

namespace FS\API\Controller;

use FS\Common\Exception\InvalidParameterException;
use FS\Common\IO;
use FS\API\Model\Resource;

class ResourceController extends Controller
{
    #region Actions
    public function create()
    {
        $this->auth->hasPermission(['write']);

        if (!($validation = IO::required($this->data, ['name', 'posterLink', 'videoLink']))['valid']) {
            throw new InvalidParameterException($validation['message']);
        }

        $resource = new Resource($this->data);

        // Check duplication

        if ($this->_checkExist()) {
            $this->responseArr['status']  = 'error';
            $this->responseArr['message'] = 'Video with link {' . $resource->getVideoLink() . '} already existed';
            return $this->responseArr;
        }

        // Insert resource item
        $sql = "INSERT INTO `resource`(`name`, `description`, `poster_link`, `video_link`, `author`, `produce_time`, `run_time`, `venue`, `views`, `note`) 
                VALUES(:name, :description, :poster_link, :video_link, :author, :produce_time, :run_time, :venue, :views, :note)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'name'         => $resource->getName(),
            'description'  => $resource->getDescription(),
            'poster_link'  => $resource->getPosterLink(),
            'video_link'   => $resource->getVideoLink(),
            'author'       => $resource->getAuthor(),
            'produce_time' => $resource->getProduceTime(),
            'run_time'     => $resource->getRunTime(),
            'venue'        => $resource->getVenue(),
            'views'        => $resource->getViews(),
            'note'         => $resource->getNote()
        ]);

        $this->responseArr['data'] = [
            'id' => $this->pdo->lastInsertId()
        ];

        return $this->responseArr;
    }

    public function update()
    {
        $this->auth->hasPermission(['write']);

        if (!($validation = IO::required($this->data, ['id']))['valid']) {
            throw new InvalidParameterException($validation['message']);
        }

        $resource = new Resource($this->data);

        // Insert resource item
        $sql = "UPDATE `resource` 
                SET `name` = :name, `description` = :description, `poster_link` = :poster_link, 
                    `video_link` = :video_link, `author` = :author, `produce_time` = :produce_time, 
                    `run_time` = :run_time, `venue` = :venue, `views` = :views, `note` = :note
                WHERE `id` = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id'           => $resource->getId(),
            'name'         => $resource->getName(),
            'description'  => $resource->getDescription(),
            'poster_link'  => $resource->getPosterLink(),
            'video_link'   => $resource->getVideoLink(),
            'author'       => $resource->getAuthor(),
            'produce_time' => $resource->getProduceTime(),
            'run_time'     => $resource->getRunTime(),
            'venue'        => $resource->getVenue(),
            'views'        => $resource->getViews(),
            'note'         => $resource->getNote()
        ]);

        return $this->responseArr;
    }

    public function delete()
    {
        $this->auth->hasPermission(['write']);

        if (!($validation = IO::required($this->data, ['id']))['valid']) {
            throw new InvalidParameterException($validation['message']);
        }

        $resource = new Resource($this->data);

        // Insert resource item
        $sql = "DELETE FROM `resource` WHERE `id` = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(['id' => $resource->getId()]);

        return $this->responseArr;
    }

    public function getById()
    {
        $this->auth->hasPermission(['read']);

        if (!($validation = IO::required($this->data, ['id']))['valid']) {
            throw new InvalidParameterException($validation['message']);
        }

        $resource = new Resource($this->data);

        // Insert resource item
        $sql = "SELECT * FROM `resource` WHERE `id` = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(['id' => $resource->getId()]);

        if (!($row = $stmt->fetch())) {
            $this->responseArr['status']  = 'error';
            $this->responseArr['message'] = 'Video with id {' . $resource->getId() . '} can NOT be found';
            return $this->responseArr;
        }

        $this->responseArr['data'] = [
            'id'           => $row['id'],
            'name'         => $row['name'],
            'description'  => $row['description'],
            'poster_link'  => $row['poster_link'],
            'video_link'   => $row['video_link'],
            'author'       => $row['author'],
            'produce_time' => $row['produce_time'],
            'venue'        => $row['venue'],
            'views'        => $row['views'],
            'note'         => $row['note']
        ];

        return $this->responseArr;
    }

    public function search()
    {
        $this->auth->hasPermission(['read']);

        $offset    = IO::getValueWithDefault($this->data, 'offset', 0);
        $limit     = IO::getValueWithDefault($this->data, 'limit', 20);
        $startTime = IO::getValueWithDefault($this->data, 'startTime');
        $endTime   = IO::getValueWithDefault($this->data, 'endTime');
        $keyword   = IO::getValueWithDefault($this->data, 'keyword');
        $orders    = [IO::getValueWithDefault($this->data, 'order')];
        $orders[]  = 'produce_time';

        //Construct SQL statement
        $sql = "SELECT * FROM `resource` ";

        $whereClause = '';
        $parameters  = [];

        if (!empty($startTime)) {
            $whereClause             = $this->appendSearch($whereClause, '`produce_time` >= :startTime');
            $parameters['startTime'] = (new \DateTime($startTime))->format('Y-m-d H:i:s');
        }

        if (!empty($endTime)) {
            $whereClause           = $this->appendSearch($whereClause, '`produce_time` <= :endTime');
            $parameters['endTime'] = (new \DateTime($startTime))->format('Y-m-d H:i:s');
        }

        if (!empty($keyword)) {
            $whereClause = $this->appendSearch($whereClause, 'MATCH(`name`, `author`, `description`, `venue`) AGAINST(:keyword)');
            $keywordArr  = explode(',', $keyword);
            $keywords    = '';
            foreach ($keywordArr as $word) {
                $keywords .= '"' . $word . '" ';
            }
            $keywords              = substr($keywords, 0, -1);
            $parameters['keyword'] = $keywords;
        }

        $orderClause = 'ORDER BY ';
        foreach ($orders as $order) {
            if (!empty($order)) {
                $orderClause .= $order . ' DESC,';
            }
        }
        $orderClause = substr($orderClause, 0, -1);

        // Retrieve total row counters
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM `resource` " . $whereClause);

        $stmt->execute($parameters);

        $rowCount = $stmt->fetchColumn(0);

        // Retrieve validated rows
        $sql .= $whereClause . ' ' . $orderClause . ' LIMIT :offset, :limit';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam('offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam('limit', $limit, \PDO::PARAM_INT);

        $stmt = $this->bindParams($stmt, $parameters);

        $stmt->execute();

        $this->responseArr['data'] = [
            'totalRowCount' => $rowCount,
            'rows'          => $stmt->fetchAll()
        ];

        return $this->responseArr;
    }

    public function checkExist()
    {
        $this->auth->hasPermission(['read']);

        $this->responseArr['data'] = ['exist' => $this->_checkExist() ? 1 : 0];

        return $this->responseArr;
    }

    // Increase view numbers of a specific resource based on `id`
    // Notes: since `increase views` is a frequent and resource-related only db action, will
    // be improved by using memcached in future
    public function increaseViews()
    {
        $this->auth->hasPermission(['write']);

        if (!($validation = IO::required($this->data, ['id']))['valid']) {
            throw new InvalidParameterException($validation['message']);
        }

        $resource = new Resource($this->data);

        // Insert resource item
        $sql = "UPDATE `resource` 
                SET `views` = `views` + 1
                WHERE `id` = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id' => $resource->getId()
        ]);

        return $this->responseArr;
    }
    #endregion

    #region Utils
    // Check resource duplication based on video_link
    private function _checkExist()
    {
        if (!($validation = IO::required($this->data, ['videoLink']))['valid']) {
            throw new InvalidParameterException($validation['message']);
        }

        $resource = new Resource($this->data);

        $sql = "SELECT COUNT(*) FROM `resource` WHERE `video_link` = :video_link";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(['video_link' => $resource->getVideoLink()]);

        return $stmt->fetchColumn() != 0;
    }
    #endregion
}
