<?php

namespace FS\Controller;

class ResourceController extends Controller
{
    #region Actions
    public function create()
    {
        $this->auth->hasPermission(['write']);

        if (!($validation = IO::required($this->data, ['ftpUser', 'fileName']))['valid']) {
            throw new InvalidParameterException($validation['message']);
        }

        $ftp = new FTPLog($this->data);

        // Insert ftp log for customer
        $sql = "INSERT INTO `ftp`(`ftp_user`, `file_name`) VALUES(:ftp_user, :file_name)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'ftp_user'  => $ftp->getFTPUser(),
            'file_name' => $ftp->getFileName()
        ]);

        $this->responseArr['data'] = [
            'id' => $this->pdo->lastInsertId()
        ];

        return $this->responseArr;
    }

    public function update()
    {
    }

    public function delete()
    {
    }

    public function getById()
    {
    }

    public function search()
    {
    }
    #endregion
}
