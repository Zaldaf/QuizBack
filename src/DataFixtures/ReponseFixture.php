<?php

namespace App\DataFixtures;

use App\Entity\Reponse;
use App\Repository\QuestionRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReponseFixture extends Fixture implements DependentFixtureInterface
{
    private QuestionRepository $questionRepository;

    /**
     * @param QuestionRepository $questionRepository
     */
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $reponses = [
            ['intitule' => 'Paris','correct' => 1,'question' => $this->questionRepository->findOneBy(['intitule' => 'Quelle est la plus grande ville de France ?'])],
            ['intitule' => 'Marseille','correct' => 0,'question' => $this->questionRepository->findOneBy(['intitule' => 'Quelle est la plus grande ville de France ?'])],
            ['intitule' => 'Besançon','correct' => 0,'question' => $this->questionRepository->findOneBy(['intitule' => 'Quelle est la plus grande ville de France ?'])],
            ['intitule' => 'Tours','correct' => 0,'question' => $this->questionRepository->findOneBy(['intitule' => 'Quelle est la plus grande ville de France ?'])],
            ['intitule' => 'Bucarest','correct' => 1,'question' => $this->questionRepository->findOneBy(['intitule' => 'Quelle est la capitale de la Roumanie ?'])],
            ['intitule' => 'Deva','correct' => 0,'question' => $this->questionRepository->findOneBy(['intitule' => 'Quelle est la capitale de la Roumanie ?'])],
            ['intitule' => 'Turda','correct' => 0,'question' => $this->questionRepository->findOneBy(['intitule' => 'Quelle est la capitale de la Roumanie ?'])],
            ['intitule' => 'Medias','correct' => 0,'question' => $this->questionRepository->findOneBy(['intitule' => 'Quelle est la capitale de la Roumanie ?'])],
            ['intitule' => 'Suisse','correct' => 1,'question' => $this->questionRepository->findOneBy(['intitule' => "Quelle pays ne fais pas partie de l'union européenne ?"])],
            ['intitule' => 'France','correct' => 0,'question' => $this->questionRepository->findOneBy(['intitule' => "Quelle pays ne fais pas partie de l'union européenne ?"])],
            ['intitule' => 'Allemagne','correct' => 0,'question' => $this->questionRepository->findOneBy(['intitule' => "Quelle pays ne fais pas partie de l'union européenne ?"])],
            ['intitule' => 'Espagne','correct' => 0,'question' => $this->questionRepository->findOneBy(['intitule' => "Quelle pays ne fais pas partie de l'union européenne ?"])],
            ['intitule' => 'Canard','correct' => 0,'question' => $this->questionRepository->findOneBy(['intitule' => "Quelle animal a 4 pattes ?"])],
            ['intitule' => 'Autruche','correct' => 0,'question' => $this->questionRepository->findOneBy(['intitule' => "Quelle animal a 4 pattes ?"])],
            ['intitule' => 'Chat','correct' => 1,'question' => $this->questionRepository->findOneBy(['intitule' => "Quelle animal a 4 pattes ?"])],
            ['intitule' => 'Singe','correct' => 0,'question' => $this->questionRepository->findOneBy(['intitule' => "Quelle animal a 4 pattes ?"])],
            ['intitule' => 'Eléphant','correct' => 0,'question' => $this->questionRepository->findOneBy(['intitule' => "Quelle animal est le plus lourd ?"])],
            ['intitule' => 'Rhinocéros ','correct' => 0,'question' => $this->questionRepository->findOneBy(['intitule' => "Quelle animal est le plus lourd ?"])],
            ['intitule' => 'Baleine ','correct' => 1,'question' => $this->questionRepository->findOneBy(['intitule' => "Quelle animal est le plus lourd ?"])],
            ['intitule' => 'Hippopotame','correct' => 0,'question' => $this->questionRepository->findOneBy(['intitule' => "Quelle animal est le plus lourd ?"])]
        ];

        foreach ($reponses as $response){
            $fixture = new Reponse();
            $fixture->setIntituler($response['intitule']);
            $fixture->setIsCorrect($response['correct']);
            $fixture->setQuestion($response['question']);

            $manager->persist($fixture);
        }



        $manager->flush();
    }
    public function  getDependencies(){
        return [
            QuestionFixture::class
        ];
    }
}
