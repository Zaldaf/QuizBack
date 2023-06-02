<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use App\Repository\ReponseRepository;
use App\Repository\ThemeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ThemeController extends AbstractController
{

    private ThemeRepository $themeRepository;
    private SerializerInterface $serializer;
    private QuestionRepository $questionRepository;
    private  EntityManagerInterface $entityManager;
    private ReponseRepository $reponseRepository;

    /**
     * @param ThemeRepository $themeRepository
     * @param SerializerInterface $serializer
     * @param QuestionRepository $questionRepository
     * @param EntityManagerInterface $entityManager
     * @param ReponseRepository $reponseRepository
     */
    public function __construct(ThemeRepository $themeRepository, SerializerInterface $serializer, QuestionRepository $questionRepository, EntityManagerInterface $entityManager, ReponseRepository $reponseRepository)
    {
        $this->themeRepository = $themeRepository;
        $this->serializer = $serializer;
        $this->questionRepository = $questionRepository;
        $this->entityManager = $entityManager;
        $this->reponseRepository = $reponseRepository;
    }


    #[Route('api/themes', name: 'app_theme',methods: "GET")]
    public function listThemes(): Response
    {
        $themes = $this->themeRepository->findAll();
        $serializedThemes = $this->serializer->serialize($themes, 'json',['groups'=>'listeTheme']);

        return new Response($serializedThemes, Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ]);
    }

    #[Route('api/theme/{id}/questions/{nb}', name: 'app_theme_question', methods: ['GET'])]
    public function getThemeQuestion($id, $nb): Response
    {

        // create the SQL statement
        $sql = 'SELECT q.id, q.intitule, t.id AS theme_id, t.libel AS theme_name FROM question q JOIN theme t ON q.theme_id = t.id WHERE t.id = :id ORDER BY RAND() LIMIT :nb';

        // create the result set mapping
        $rsm = new ResultSetMappingBuilder($this->entityManager);
        $rsm->addRootEntityFromClassMetadata(Question::class, 'q');

        // create the native query
        $query = $this->entityManager->createNativeQuery($sql, $rsm);
        $query->setParameter('id', $id);
        $query->setParameter('nb', $nb, \PDO::PARAM_INT);

        // get the results
        $questions = $query->getResult();

        $QuestionJson = $this->serializer->serialize($questions, 'json' ,['groups'=>'getQuestion']);

        return new Response($QuestionJson , Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    #[Route('/api/question/reponses/{questionId}', name: 'app_api_get_question_responses',methods: ["GET"])]
    public function getQuestionResponses(int $questionId): Response
    {

        $question = $this->questionRepository->find($questionId);

        $responses = $question->getReponses();

        $json = $this->serializer->serialize($responses, "json", ['groups' => 'get_responses']);

        return new Response($json, 200, []);

    }

    #[Route('/api/question/reponses/post', name: 'app_api_post_question_response', methods: ['POST'])]
    public function postQuestionReponses(Request $request): Response
    {
        $returnReponses = [];

        $reponses = $request->toArray();

        foreach ($reponses as $key => $reponseId) {

            $returnReponses[] = [
                "key" => $key,
                "id" => $reponseId,
                "question" => $this->reponseRepository->find($reponseId)->getQuestion()->getIntitule(),
                "isCorrect" => $this->reponseRepository->find($reponseId)->isIsCorrect()
            ];
        }

        return new Response(json_encode($returnReponses) , 200, []);
    }

}
