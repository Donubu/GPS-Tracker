<?php declare(strict_types=1);

namespace App\Domains\Timezone\Model\Builder;

use App\Domains\SharedApp\Model\Builder\BuilderAbstract;
use App\Domains\Timezone\Model\Timezone as Model;

class Timezone extends BuilderAbstract
{
    /**
     * @param float $latitude
     * @param float $longitude
     *
     * @return self
     */
    public function byLatitudeLongitude(float $latitude, float $longitude): self
    {
        return $this->whereRaw('ST_CONTAINS(`geojson`, POINT(?, ?))', [$longitude, $latitude]);
    }

    /**
     * @param string $zone
     *
     * @return self
     */
    public function byZone(string $zone): self
    {
        return $this->where('zone', $zone);
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->whereGeojson()->orderBy('zone', 'ASC');
    }

    /**
     * @return self
     */
    public function whereGeojson(): self
    {
        return $this->whereRaw('`geojson` != '.Model::emptyGeoJSON());
    }
}
