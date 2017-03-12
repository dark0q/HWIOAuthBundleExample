<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        //you can access token
        //$token = $this->get('security.token_storage')->getToken();
        //or get token from user that you while login updated
        $token = $this->getUser() ? $this->getUser()->getMyCustomServerAccessToken() : null;

        $auth = "Authorization: Bearer {$token}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'server.inteda.pl/api/user.json');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: application/json', $auth]); // Assuming you're requesting JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        //$data = json_decode($response);


        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'data' => $response
        ]);
    }
}
