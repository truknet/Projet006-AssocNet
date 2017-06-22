<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Showcase
 *
 * @ORM\Table(name="showcase")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ShowcaseRepository")
 */
class Showcase
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
     * @ORM\Column(name="theme", type="string", length=255)
     */
    private $theme;

    /**
     * @var string
     *
     * @ORM\Column(name="$colorBackground", type="string", length=255, nullable=true)
     */
    private $colorBackground;


    /**
     * @var string
     *
     * @ORM\Column(name="block1Title", type="string", length=255, nullable=true)
     */
    private $block1Title;

    /**
     * @var string
     *
     * @ORM\Column(name="block1Subtitle", type="string", length=255, nullable=true)
     */
    private $block1Subtitle;

    /**
     * @var string
     *
     * @ORM\Column(name="block1Content", type="text", nullable=true)
     */
    private $block1Content;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->theme = 'css/Bootswatch3/bootstrap/bootstrap.min.css';
    }


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
     * Set theme
     *
     * @param string $theme
     *
     * @return Showcase
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Set block1Title
     *
     * @param string $block1Title
     *
     * @return Showcase
     */
    public function setBlock1Title($block1Title)
    {
        $this->block1Title = $block1Title;

        return $this;
    }

    /**
     * Get block1Title
     *
     * @return string
     */
    public function getBlock1Title()
    {
        return $this->block1Title;
    }

    /**
     * Set block1Subtitle
     *
     * @param string $block1Subtitle
     *
     * @return Showcase
     */
    public function setBlock1Subtitle($block1Subtitle)
    {
        $this->block1Subtitle = $block1Subtitle;

        return $this;
    }

    /**
     * Get block1Subtitle
     *
     * @return string
     */
    public function getBlock1Subtitle()
    {
        return $this->block1Subtitle;
    }

    /**
     * Set block1Content
     *
     * @param string $block1Content
     *
     * @return Showcase
     */
    public function setBlock1Content($block1Content)
    {
        $this->block1Content = $block1Content;

        return $this;
    }

    /**
     * Get block1Content
     *
     * @return string
     */
    public function getBlock1Content()
    {
        return $this->block1Content;
    }

    /**
     * Set colorBackground
     *
     * @param string $colorBackground
     *
     * @return Showcase
     */
    public function setColorBackground($colorBackground)
    {
        $this->colorBackground = $colorBackground;

        return $this;
    }

    /**
     * Get colorBackground
     *
     * @return string
     */
    public function getColorBackground()
    {
        return $this->colorBackground;
    }
}
