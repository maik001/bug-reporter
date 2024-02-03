<?php declare(strict_types=1);

namespace App\Entities;

class BugReport extends Entity
{
    private $id;
    private $report_type;
    private $email;
    private $link;
    private $message;
    private $created_at;

    public function getId(): int
    {
        return $this->id;
    }

    public function setReportType(string $reportType)
    {
        $this->report_type = $reportType;
        return $this;
    }

    public function getReportType(): string
    {
        return $this->report_type;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setLink(?string $link)
    {
        $this->link = $link;
        return $this;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;
        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function toArray(): array
    {
        return [
            'report_type' => $this->getReportType(),
            'email' => $this->getEmail(),
            'message' => $this->getMessage(),
            'link' => $this->getLink(),
            'created_at' => date('Y-m-d H:i:s'),
        ];
    }
}