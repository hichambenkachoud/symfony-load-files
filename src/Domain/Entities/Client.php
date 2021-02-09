<?php


namespace App\Domain\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as Serializer;

/**
 * Class Client
 * @package App\Domain\Entities
 * @Serializer\ExclusionPolicy("all")
 */
class Client
{
    const COL_ID = 'id_unique';
    const COL_NAME = 'nom';
    const COL_CIN= 'cin';
    const COL_CODE = 'code_compta';
    const COL_DEPOSIT_DATE = 'date_depot';
    const COL_DECISION = 'decisions';

    /**
     * @var integer
     * @Serializer\Expose
     * @Serializer\Groups({"ClientList"})
     *
     */
    private $id_unique;

    /**
     * @var string
     * @Serializer\Expose
     * @Serializer\Groups({"ClientList"})
     */
    private $nom;

    /**
     * @var string
     * @Serializer\Expose
     * @Serializer\Groups({"ClientList"})
     */
    private $cin;

    /**
     * @var integer
     * @Serializer\Expose
     * @Serializer\Groups({"ClientList"})
     */
    private $code_compta;

    /**
     * @var \DateTimeInterface
     * @Serializer\Expose
     * @Serializer\Groups({"ClientList"})
     */
    private $date_depot;

    /**
     * @var ArrayCollection
     * @Serializer\Expose
     * @Serializer\Groups({"ClientList"})
     */
    private $decisions;

    /**
     * Client constructor.
     * @param string $nom
     * @param string $cin
     * @param int $code_compta
     * @param \DateTimeInterface $date_depot
     * @param $decisions
     */
    private function __construct(
        string $nom,
        string $cin,
        int $code_compta,
        \DateTimeInterface $date_depot,
        $decisions
    )
    {
        $this->nom = $nom;
        $this->cin = $cin;
        $this->code_compta = $code_compta;
        $this->date_depot = $date_depot;
        $this->decisions = new ArrayCollection();

        array_map(function ($decision){
            $this->addDecision($decision);
        }, $decisions->toArray());
    }


    /**
     * @return int
     */
    public function getIdUnique(): int
    {
        return $this->id_unique;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getCin(): string
    {
        return $this->cin;
    }

    /**
     * @param string $cin
     */
    public function setCin(string $cin): void
    {
        $this->cin = $cin;
    }

    /**
     * @return int
     */
    public function getCodeCompta(): int
    {
        return $this->code_compta;
    }

    /**
     * @param int $code_compta
     */
    public function setCodeCompta(int $code_compta): void
    {
        $this->code_compta = $code_compta;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDateDepot(): \DateTimeInterface
    {
        return $this->date_depot;
    }

    /**
     * @param \DateTimeInterface $date_depot
     */
    public function setDateDepot(\DateTimeInterface $date_depot): void
    {
        $this->date_depot = $date_depot;
    }

    /**
     * @return Collection|Decision[]
     */
    public function getDecisions()
    {
        return $this->decisions;
    }

    /**
     * @param Decision $decision
     * @return $this
     */
    public function addDecision(Decision $decision): self
    {
        if (!$this->decisions->contains($decision)) {
            $this->decisions[] = $decision;
            $decision->setClient($this);
        }
        return $this;
    }

    /**
     * @param Decision $decision
     * @return $this
     */
    public function removeDecision(Decision $decision): self
    {
        if ($this->decisions->removeElement($decision)) {
            // set the owning side to null (unless already changed)
            if ($decision->getClient() === $this) {
                $decision->setClient(null);
            }
        }
        return $this;
    }

    /**
     * @param string $nom
     * @param string $cin
     * @param int $code_compta
     * @param \DateTimeInterface $date_depot
     * @param array $decisions
     * @return Client
     */
    public static function fromArray(
        string $nom,
        string $cin,
        int $code_compta,
        \DateTimeInterface $date_depot,
        $decisions
    ): Client
    {
        return new self($nom, $cin, $code_compta, $date_depot, $decisions);
    }

}
