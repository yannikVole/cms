<?php
namespace App\Controller;

use App\Entity\MediaItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Route("/media")
 * Class MediaController
 * @package App\Controller
 */
class MediaController extends AbstractController{

    /**
     * @Route("/upload", name="media_upload")
     */
    public function upload(Request $request){
        $mediaItem = new MediaItem();

        $form = $this->createFormBuilder($mediaItem)
            ->add("filename", FileType::class)
            ->add("description", TextType::class,[
                "required" => false
            ])
            ->add("submit", SubmitType::class,[
                "label" => "Upload"
            ])
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $mediaItem->setUser($this->getUser());
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = new UploadedFile($mediaItem->getFilename(),$mediaItem->getFilename());
            // handle file upload and save path to database
            $fileName = $this->generateUniqueFilename().'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter("media_directory"),
                    $fileName
                );
            } catch (FileException $e){
                die($e);
            }
            $mediaItem->setFilename($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($mediaItem);
            $em->flush();
            //redirect to uploaded media
            return $this->redirect($this->generateUrl("media_show_item",[
                "fileName" => $fileName
            ]));
        }


        return $this->render("media/upload.html.twig",[
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/all",name="media_show_all")
     */
    public function all(){
        $em = $this->getDoctrine()->getManager();
        $mediaItems = $em->getRepository(MediaItem::class)->findAll();
        return $this->render("media/show_all.html.twig",[
            "mediaItems" => $mediaItems
        ]);
    }

    /**
     * @Route("/show/{fileName}", name="media_show_item")
     */
    public function show($fileName){
        return $this->render("media/show.html.twig",[
            "fileName" => $fileName
        ]);
    }

    private function generateUniqueFilename()
    {
        return md5(uniqid('', true));
    }
}
