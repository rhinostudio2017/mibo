<?php

namespace FS\Common;

use FS\Common\Exception\InvalidParameterException;
use FS\Common\Exception\MailException;

class Mail
{
    #region Fields
    private $server;
    private $port;
    private $username;
    private $password;
    private $type;
    private $crlf;
    private $socket;
    private $from;
    private $to;
    private $subject;
    private $message;
    #endregion

    #region Getters and Setters
    public function __construct($config)
    {
        set_time_limit(600);

        if (isset($config['server'])) {
            $this->server = $config['server'];
        } else {
            throw new InvalidParameterException('Parameter {server} in configuration file is not valid');
        }

        if (isset($config['port'])) {
            $this->port = $config['port'];
        } else {
            $this->port = 25;
        }

        $this->type   = 0;
        $this->crlf   = chr(10);
        $this->socket = null;

        if (isset($config['from'])) {
            if (!$this->validEmail($config['from'])) {
                throw new InvalidParameterException('Parameter {from} in configuration file is not a valid email');
            }

            $this->from = $config['from'];
        }

        if (isset($config['to'])) {
            if (!$this->validEmail($config['to'])) {
                throw new InvalidParameterException('Parameter {to} in configuration file is not a valid email');
            }

            $this->to = $config['to'];
        }

        if (isset($config['subject']) && $this->validateSubject($config['subject'])) {
            $this->subject = $config['subject'];
        } else {
            $this->subject = 'No subject';
        }

        if (isset($config['message'])) {
            $this->message = $config['message'];
        } else {
            $this->message = 'No message';
        }
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setFrom($from)
    {
        if (!$this->validEmail($from)) {
            throw new InvalidParameterException('Passed in parameter {from} is not a valid email');
        }

        $this->from = $from;
    }

    public function setTo($to)
    {
        if (!$this->validEmail($to)) {
            throw new InvalidParameterException('Passed in parameter {to} is not a valid email');
        }

        $this->to = $to;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }
    #endregion

    #region Methods
    public function send()
    {
        if (!isset($this->from) || !isset($this->to)) {
            throw new InvalidParameterException('Make sure {from} and {to} are set properly before sending email');
        }

        $this->connect();
        $this->handshake();
        $this->sendMail();
        $this->quitMail();
    }
    #endregion

    #region Utils
    private function validateSubject($subject)
    {
        return strpos($subject, PHP_EOL) === false;
    }

    private function sanitizeEmail($email)
    {
        $flag = preg_match_all('/(<[^<>]+@[^<>]+>)/', $email, $matches);

        if ($flag !== 0 && $flag !== false) {
            return $matches[1];
        } else {
            return null;
        }
    }

    private function validEmail($email)
    {
        $matches = $this->sanitizeEmail($email);
        $flag    = $matches === null ? false : true;
        $count   = count($matches);

        for ($i = 1; $i < $count; $i++) {
            if (filter_var(preg_replace(['/\s*/', '/|/', '/</', '/>/', '/:/'], '', $matches[$i]),
                    FILTER_VALIDATE_EMAIL) === false
            ) {
                $flag = false;
                break;
            }
        }

        return $flag;
    }

    private function connect()
    {
        $this->socket = fsockopen($this->server, $this->port);

        if ($this->socket === false) {
            new MailException('Failed to open socket with SMTP server.');
        }

        $responseArr = explode(' ', $this->readMail());

        if ($responseArr[0] != 220) {
            new MailException('Failed to connect to SMTP server.');
        }
    }

    private function readMail()
    {
        // Retrieving stuff from the server for the first 100 bytes.
        $line = '';

        while (true) {
            if (feof($this->socket)) {
                return (0);
            }

            $line .= fgets($this->socket, 100);

            $length = strlen($line);

            if (($length >= 2) && (ord(substr($line, -1)) === 10)) {
                $line = substr($line, 0, -1);

                if (ord(substr($line, -1)) === 13) {
                    $this->type = 1;
                    $this->crlf = chr(13) . chr(10);
                    $line       = substr($line, 0, -1);
                }
                return ($line);
            }
        }
    }

    private function writeMail($data)
    {
        $length = fputs($this->socket, $data . $this->crlf);

        if ($length === false) {
            new MailException('Failed to write to SMTP server.');
        }
    }

    private function handshake()
    {
        $hello = 'HELO ' . $this->server;

        $this->writeMail($hello);

        $responseArr = explode(' ', $this->readMail());

        if ($responseArr[0] != 250) {
            new MailException('Failed handshake with SMTP server.');
        }
    }

    private function sendMail()
    {
        $from = $this->sanitizeEmail($this->from);

        if ($from === null) {
            throw new MailException('Passed in parameter {MAIL_FROM} is not set correctly in configuration file.');
        }

        $this->writeMail('MAIL FROM: ' . $from[0]);

        $responseArr = explode(' ', $this->readMail());

        if ($responseArr[0] != 250) {
            new MailException('Command {MAIL FROM} failed in SMTP server.');
        }

        $to = $this->sanitizeEmail($this->to);
        if ($to === null) {
            throw new MailException('Passed in parameter {MAIL_TO} is set not correctly in configuration file.');
        }

        $count = count($to);

        for ($i = 0; $i < $count; $i++) {
            $this->writeMail('RCPT TO: ' . $to[$i]);

            $responseArr = explode(' ', $this->readMail());

            if ($responseArr[0] != 250) {
                new MailException('Command {RCPT TO} failed in SMTP server.');
            }
        }

        $this->writeMail('DATA');

        $responseArr = explode(' ', $this->readMail());

        if ($responseArr[0] != 354) {
            new MailException('Command {DATA} failed in SMTP server.');
        }

        $this->writeMail('From: ' . $this->from);
        $this->writeMail('To: ' . $this->to);
        $this->writeMail('Subject: ' . $this->subject . $this->crlf);
        $this->writeMail($this->message);
        $this->writeMail('.');

        $responseArr = explode(' ', $this->readMail());

        if ($responseArr[0] != 250) {
            new MailException('Failed to write content to SMTP server.');
        }
    }

    private function quitMail()
    {
        $this->writeMail('QUIT');

        $responseArr = explode(' ', $this->readMail());

        if ($responseArr[0] != 221) {
            new MailException('Command {QUIT} failed in SMTP server.');
        }
    }
    #endregion
}
