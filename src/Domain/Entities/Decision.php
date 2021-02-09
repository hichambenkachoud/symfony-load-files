<?php


namespace App\Domain\Entities;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class Decision
 * @package App\Domain\Entities
 *  @Serializer\ExclusionPolicy("all")
 */
class Decision
{

    const COL_ID = 'id';
    const COL_TYPE = 'type_acte';
    const COL_DECISION= 'decision';
    const COL_CLIENT= 'client';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups({"ClientList"})
     */
    private $type_acte;

    /**
     * @var string
     * @Serializer\Expose
     * @Serializer\Groups({"ClientList"})
     */
    private $decision;

    /**
     * @var Client
     */
    private $client;

    /**
     * Decision constructor.
     * @param string $type_acte
     * @param string $decision
     */
    private function __construct(
        string $type_acte,
        string $decision
    )
    {
        $this->type_acte = $type_acte;
        $this->decision = $decision;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTypeActe(): string
    {
        return $this->type_acte;
    }

    /**
     * @param string $type_acte
     */
    public function setTypeActe(string $type_acte): void
    {
        $this->type_acte = $type_acte;
    }

    /**
     * @return string
     */
    public function getDecision(): string
    {
        return $this->decision;
    }

    /**
     * @param string $decision
     */
    public function setDecision(string $decision): void
    {
        $this->decision = $decision;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    /**
     * @param string $type_acte
     * @param string $decision
     * @return Decision
     */
    public static function fromArray(
        string $type_acte,
        string $decision
    ): Decision
    {
        return new self($type_acte, $decision);
    }
}
