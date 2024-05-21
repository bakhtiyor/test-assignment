<?php

namespace App;

class AssetRepository
{
    public function __construct(private readonly DB $db)
    {
    }

    public function getAssetsWithActiveVulnerabilitiesDiscovered3MonthAgo(): array
    {
        $sql = "SELECT a.id, a.name asset FROM asset a
                INNER JOIN vulnerability v ON a.id = v.asset_id
                WHERE v.discovered_at >= DATE_SUB(NOW(), INTERVAL 3 MONTH) and v.archived_at IS NULL";
        return $this->db->execute($sql, []);
    }

    public function getActiveVulnerabilitiesForGivenTypeAndSourceType(string $type, string $sourceType): array
    {
        $sql = "SELECT v.name, v.severity FROM vulnerability v
                INNER JOIN asset a ON a.id = v.asset_id
                WHERE a.type = ? AND a.source_type = ?
                AND v.archived_at IS NULL";
        return $this->db->execute($sql, [$type, $sourceType]);
    }

    public function getAssetsWithArchivedVulnerabilities(): array
    {
        $sql = "SELECT a.name, max(v.archived_at) archived_at FROM asset a
                INNER JOIN vulnerability v ON a.id = v.asset_id
                WHERE v.archived_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH) 
                GROUP BY a.name";
        return $this->db->execute($sql, []);
    }

    public function getAssetsWithMultipleSeverities(): array
    {
        $sql = "SELECT a.name AS asset_name, v.name AS vulnerability_name
                FROM asset a
                INNER JOIN vulnerability v ON a.id = v.asset_id
                GROUP BY a.name, v.name
                HAVING COUNT(DISTINCT v.severity) > 1";
        return $this->db->execute($sql, null);
    }

    public function __destruct()
    {
        $this->db->close();
    }
}