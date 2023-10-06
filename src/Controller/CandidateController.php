<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\Files;
use App\Form\CandidateType;
use App\Repository\CandidateRepository;
use App\Repository\JobCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/candidate')]
class CandidateController extends AbstractController
{
    #[Route('/', name: 'app_candidate_index', methods: ['GET'])]
    public function index(CandidateRepository $candidateRepository): Response
    {
        return $this->render('candidate/index.html.twig', [
            'candidates' => $candidateRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_candidate_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $candidate = new Candidate();
        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($candidate);
            $entityManager->flush();

            return $this->redirectToRoute('app_candidate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('candidate/new.html.twig', [
            'candidate' => $candidate,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_candidate_show', methods: ['GET'])]
    public function show(Candidate $candidate): Response
    {
        return $this->render('candidate/show.html.twig', [
            'candidate' => $candidate,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_candidate_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserPasswordHasherInterface $userPasswordHasher, Candidate $candidate, JobCategoryRepository $jobCategoryRepository, EntityManagerInterface $entityManager): Response
    {
        $jobsCategory = $jobCategoryRepository->findAll();
        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $filePicture = $form['profil_picture']->getData();
            $filePassport = $form['passport_file']->getData();
            $fileCv = $form['cv']->getData();
            
            $user= $candidate->getUser();
            if(null !== ($form->get('user')->get('plainPassword')->getData())) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('user')->get('plainPassword')->getData()
                )
            );}
            
            if ($filePicture) {
                // Gérez le téléchargement du fichier, par exemple, déplacez-le vers un répertoire d'uploads.
                $uploadsDirectory = $this->getParameter('uploads_directory');
                $fileName = md5(uniqid()).'.'.$filePicture->guessExtension();
                $filePicture->move($uploadsDirectory, $fileName);

                $files = new Files();
                $files->setSource($fileName); // Associez le candidat à l'utilisateur.
                
                // Persistez le candidat en base de données.
                $entityManager->persist($files);
                $entityManager->flush();
                
                // Enregistrez le nom du fichier dans l'entité Candidate si nécessaire.
                $candidate->setProfilPicture($files);
            }
            if ($filePassport) {
                // Gérez le téléchargement du fichier, par exemple, déplacez-le vers un répertoire d'uploads.
                $uploadsDirectory = $this->getParameter('uploads_directory');
                $fileName = md5(uniqid()).'.'.$filePassport->guessExtension();
                $filePassport->move($uploadsDirectory, $fileName);

                $files = new Files();
                $files->setSource($fileName); // Associez le candidat à l'utilisateur.
                
                // Persistez le candidat en base de données.
                $entityManager->persist($files);
                $entityManager->flush();
                // Enregistrez le nom du fichier dans l'entité Candidate si nécessaire.
                $candidate->setPassportFile($files);
            }
            if ($fileCv) {
                // Gérez le téléchargement du fichier, par exemple, déplacez-le vers un répertoire d'uploads.
                $uploadsDirectory = $this->getParameter('uploads_directory');
                $fileName = md5(uniqid()).'.'.$fileCv->guessExtension();
                $fileCv->move($uploadsDirectory, $fileName);

                $files = new Files();
                $files->setSource($fileName); // Associez le candidat à l'utilisateur.
                
                // Persistez le candidat en base de données.
                $entityManager->persist($files);
                $entityManager->flush();
                
                // Enregistrez le nom du fichier dans l'entité Candidate si nécessaire.
                $candidate->setCv($files);
            }
            $timeZone = new \DateTimeZone('Europe/Paris');
            $idCandidate = $candidate->getId();
            $candidate->setUpdatedAt(new \DateTimeImmutable('now', $timeZone));
            $entityManager->flush();

            return $this->redirectToRoute('app_candidate_edit', ['id' => $idCandidate], Response::HTTP_SEE_OTHER);
        }

        return $this->render('candidate/edit.html.twig', [
            'candidate' => $candidate,
            'form' => $form,
            'jobsCategory' => $jobsCategory,

        ]);
    }

    #[Route('/{id}', name: 'app_candidate_delete', methods: ['POST'])]
    public function delete(Request $request, Candidate $candidate, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$candidate->getId(), $request->request->get('_token'))) {
            $entityManager->remove($candidate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_register', [], Response::HTTP_SEE_OTHER);
    }
}
