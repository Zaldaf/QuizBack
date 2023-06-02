<?php

namespace App\DataFixtures;

use App\Entity\Theme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class ThemeFixture extends Fixture

{

    private SluggerInterface $slugger;

    /**
     * @param SluggerInterface $slugger
     */
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }


    public function load(ObjectManager $manager): void


    {

        $themes = [
            ['libel' => 'Geographie'],
            ['libel' => 'Animaux']
        ];




        $i = 0 ;
        foreach ($themes as $theme){
            $fixture = new Theme();
            $fixture->setLibel($theme['libel']);
            $fixture->setSlug($this->slugger->slug($fixture->getLibel()));
            $this->addReference("theme".$i,$fixture);
            $manager->persist($fixture);
            $i++;
        }

        $manager->flush();
    }
}
