<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\Type\UserPerfilType;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin/usuario")
 */
class UserController extends AbstractController
{
    private $passwordEncoder;

    public $usuarioRepository;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, UserRepository $usuarioRepository)
    {
        $this->passwordEncoder = $passwordEncoder;

        $this->usuarioRepository = $usuarioRepository;
    }

    /**
     * @Route("/", name="user_index", methods={"GET"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'user' => $userRepository->findAll(),
        ]);
    }

     /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $plainpwd = $user->getPassword();
            $encoded = $this->passwordEncoder->encodePassword($user,$plainpwd);
            $user->setPassword($encoded);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $plainpwd = $user->getPassword();
            $encoded = $this->passwordEncoder->encodePassword($user,$plainpwd);
            $user->setPassword($encoded);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="user_remove")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function remove(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(User::class)->find($id);

        if (!$entity) {
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_warning','No se encuentra este Usuario!!!');
        } else {
            $em->remove($entity);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->add('app_error','Se ha eliminado un Usuario satisfactoriamente!!!');
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/change/userdenegar", name="change_user_denegar", methods={"GET","POST"})
     */
    public function changeEnDenegarUser(Request $request): JsonResponse
    {
        $value = $request->get('value') == 'false' ? false : true;
        $id = $request->get('id');
        $entity = $this->usuarioRepository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $action = 'esDenegar';
        $entity->setEsDenegar($value);
        $entityManager->persist($entity);
        $entityManager->flush();

        return new JsonResponse(array('response' => $action));
    }

    /**
     * @Route("/perfil/mostrar", name="user_perfil", methods={"GET","POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function perfilUser(Request $request): Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $form = $this->createForm(UserPerfilType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $plainpwd = $user->getPassword();
            $encoded = $this->passwordEncoder->encodePassword($user,$plainpwd);
            $user->setPassword($encoded);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('user/perfil.html.twig', [
            'user'    => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/getmunicipiouxprovinciau", name="municipiou_x_provinciau", methods={"GET","POST"})
     */
    public function getMunicipiouxProvinciau(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $provincia_id = $request->get('provincia_id');
        $municipio = $em->getRepository('App:Municipio')->findByProvinciau($provincia_id);
        return new JsonResponse($municipio);
    }

    /**
     * @Route("/getinstitucionuxmunicipiou", name="institucionu_x_municipiou", methods={"GET","POST"})
     */
    public function getInstitucionuxMunicipiou(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $municipio_id = $request->get('municipio_id');
        $institucion = $em->getRepository('App:Institucion')->findByMunicipiou($municipio_id);
        return new JsonResponse($institucion);
    }
}