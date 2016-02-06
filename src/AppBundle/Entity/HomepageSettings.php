<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HomepageSettings
 *
 * @ORM\Table(name="settings_homepage")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\HomepageSettingsRepository")
 */
class HomepageSettings
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="trading_name", type="string", length=255)
     */
    private $tradingName;

    /**
     * @var string
     *
     * @ORM\Column(name="main_heading", type="string", length=255, nullable=true)
     */
    private $mainHeading;

    /**
     * @var string
     *
     * @ORM\Column(name="sub_heading", type="string", length=255, nullable=true)
     */
    private $subHeading;

    /**
     * @var string
     *
     * @ORM\Column(name="partner_heading", type="string", length=255, nullable=true)
     */
    private $partnerHeading;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tradingName
     *
     * @param string $tradingName
     *
     * @return HomepageSettings
     */
    public function setTradingName($tradingName)
    {
        $this->tradingName = $tradingName;

        return $this;
    }

    /**
     * Get tradingName
     *
     * @return string
     */
    public function getTradingName()
    {
        return $this->tradingName;
    }

    /**
     * Set mainHeading
     *
     * @param string $mainHeading
     *
     * @return HomepageSettings
     */
    public function setMainHeading($mainHeading)
    {
        $this->mainHeading = $mainHeading;

        return $this;
    }

    /**
     * Get mainHeading
     *
     * @return string
     */
    public function getMainHeading()
    {
        return $this->mainHeading;
    }

    /**
     * Set subHeading
     *
     * @param string $subHeading
     *
     * @return HomepageSettings
     */
    public function setSubHeading($subHeading)
    {
        $this->subHeading = $subHeading;

        return $this;
    }

    /**
     * Get subHeading
     *
     * @return string
     */
    public function getSubHeading()
    {
        return $this->subHeading;
    }

    /**
     * Set partnerHeading
     *
     * @param string $partnerHeading
     *
     * @return HomepageSettings
     */
    public function setPartnerHeading($partnerHeading)
    {
        $this->partnerHeading = $partnerHeading;

        return $this;
    }

    /**
     * Get partnerHeading
     *
     * @return string
     */
    public function getPartnerHeading()
    {
        return $this->partnerHeading;
    }
}
