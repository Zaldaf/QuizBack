<?php

namespace App\DataFixtures;

use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class QuestionFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $questions = [
            ['intituler' => 'Quelle est la capitale de la Roumanie ?','theme' => $this->getReference("theme".(0))],
            ['intituler' => 'Quelle est la plus grande ville de France ?','theme' => $this->getReference("theme".(0))],
            ['intituler' => "Quelle pays ne fais pas partie de l'union européenne ?",'theme' => $this->getReference("theme".(0))],
            ['intituler' => "Quelle animal a 4 pattes ?",'theme' => $this->getReference("theme".(1))],
            ['intituler' => "Quelle animal est le plus lourd ?",'theme' => $this->getReference("theme".(1))]

        ];

        foreach ($questions as $question){
            $fixture = new Question();
            $fixture->setIntitule($question['intituler']);
            $fixture->setTheme($question['theme']);
            $manager->persist($fixture);
        }



        $manager->flush();
    }
    public function  getDependencies(){
        return [
            ThemeFixture::class
        ];
    }
}
