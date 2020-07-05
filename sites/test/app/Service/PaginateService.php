<?php
namespace Service;
class PaginateService
{
    public function pageCount(int $rows):int
    {
        return ($rows+1)/2;
    }
}
