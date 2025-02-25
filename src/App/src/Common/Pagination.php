<?php

declare(strict_types=1);

namespace Frontend\App\Common;

/**
 * Class Pagination
 * @package Frontend\App\Common
 */
class Pagination
{
    public const LIMIT = 10;

    /**
     * @param array $filters
     * @return array
     */
    public static function getOffsetAndLimit(array $filters = []): array
    {
        $page = (int)($filters['page'] ?? 1);

        $offset = 0;
        $limit = 1000;
        if (!array_key_exists('all', $filters)) {
            $offset = ($page - 1) * self::LIMIT;
            $limit = self::LIMIT;
        }

        return [
            'offset' => $offset,
            'limit' => $limit
        ];
    }
}
