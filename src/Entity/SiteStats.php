<?php

namespace App\Entity;

class SiteStats {
    public ?\DateTimeInterface $date;
    public int $visitors;
    public int $pageviews;

    public static function fromArray(array $data): self
    {
        $obj = new self;
        $obj->date = isset($data['date']) ? new \DateTimeImmutable($data['date']) : null;
        $obj->visitors = (int) $data['visitors'];
        $obj->pageviews = (int) $data['pageviews'];
        return $obj;
    }
}