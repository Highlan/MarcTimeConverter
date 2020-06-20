<?php
/**
 * Created by PhpStorm.
 * User: Fatemeh
 * Date: 6/19/2020
 * Time: 10:02 PM
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends AbstractController
{

    public function index(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}