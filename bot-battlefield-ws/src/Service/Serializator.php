<?php

namespace App\Service;

use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class Serializator
 * @package App\Service
 */
final class Serializator
{

    private
        /**
         * @var SerializerInterface
         */
        $serializer;

    /**
     * RatchetableController constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param $data
     * @param string $property
     * @param array $groups
     * @return string
     */
    public function serialize($data, string $property, array $groups = []): string
    {
        return '{"' . $property . '":' . $this->serializer->serialize($data, "json", ["groups" => $groups]) . '}';
    }

}
