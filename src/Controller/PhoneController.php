<?php

namespace App\Controller;

use App\Entity\Phone;
use App\Form\AddPhoneType;
use App\Repository\PhoneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class PhoneController extends AbstractController
{
    #[Route('/phone', name: 'app_phone')]
    public function index(): Response
    {
        return $this->render('phone/index.html.twig', [
            'controller_name' => 'PhoneController',
        ]);
    }

    #[Route('/phone/add', name: 'app_phone_add', priority: 1)]
    public function addAction(Request $request, PhoneRepository $phoneRepository, SluggerInterface $slugger):Response
    {
        $form = $this->createForm(AddPhoneType::class, new Phone());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $phone = $form->getData();
            $image = $form->get('image')->getData();
            if ($image){
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid().'.'.$image->guessExtension();

                try {
                    $image->move($this->getParameter('images_directory'), $newFilename);
                }catch (FileException $e){
                    echo $e;
                }
                $phone->setImage($newFilename);
                $phoneRepository->save($phone, true);
                $this->addFlash('success', 'Adding car is successfully');
                return $this->redirectToRoute('app_car_add');
            }
        }
        return $this->render('phone/add.html.twig',[
            'form'=>$form
        ]);
    }
}
