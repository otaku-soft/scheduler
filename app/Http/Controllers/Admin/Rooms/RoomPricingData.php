<?php
namespace App\Http\Controllers\Admin\Rooms;
use App\Models\RoomPricing;
use App\Models\RoomStoreLinkPrices;
class RoomPricingData
{
    /**
     * @var int
     */
    private  ?int $id;
    /**
     * @var int
     */
    private int $room_id;

    /**
     * @var string
     */
    private string $type;

    /**
     * @var int
     */
    private int $person_number;

    /**
     * @var float
     */
    private ?float $price;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getRoomId(): int
    {
        return $this->room_id;
    }

    /**
     * @param int $room_id
     * @return void
     */
    public function setRoomId(int $room_id): void
    {
        $this->room_id = $room_id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return void
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getPersonNumber(): int
    {
        return $this->person_number;
    }

    /**
     * @param int $person_number
     * @return void
     */
    public function setPersonNumber(int $person_number): void
    {
        $this->person_number = $person_number;
    }

    /**
     * @return float
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return void
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
    public function __construct(int $room_id,string $type,int $personNumber)
    {
        $this->id = null;
        $this->type = $type;
        $this->price = null;
        $this->person_number = $personNumber;
        $this->room_id = $room_id;
    }
    public function copyFromEntity(RoomPricing | RoomStoreLinkPrices  $price)
    {
        $this->id = $price->id;
        $this->type = $price->type;
        $this->price = $price->price;
        $this->person_number = $price->person_number;
    }
}