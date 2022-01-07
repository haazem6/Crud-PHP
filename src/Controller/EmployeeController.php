<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Employee;
use App\Form\EmployeeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request ;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class EmployeeController extends AbstractController
{
    /**
     * @Route("/", name="employee")
     */
    public function index(): Response
    {
        return $this->render('employee/index.html.twig', [
            'controller_name' => 'EmployeeController',
        ]);
    }

    /**
     * @Route("/ajouter", name="ajouter")
     */
    public function ajouter(Request $request): Response
    {
         $Employee = new Employee();
     
        $form= $this->createForm(EmployeeType::class,$Employee);
       $form->handleRequest($request);
       //var_dump($request);
       if ($form->isSubmitted() && $form->isValid())
       {
           $em=$this->getDoctrine()->getManager();
           $em->persist($Employee);
           $em->flush();
           $session=new Session();
           $session->getFlashBag()->add('notice','Job bien enregistree');
        //    return $this->redirectToRoute('home',array('id'=>$Employee->getId()));
        return $this->redirectToRoute('employee');
       }
       return $this->render('employee/ajouter.html.twig',array('form'=> $form->createView()));
    }
}


