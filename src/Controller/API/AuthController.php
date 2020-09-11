<?php
/**
 * Created by PhpStorm.
 * User: temerso_test
 * Date: 15.06.2020
 * Time: 08:56
 */

namespace App\Controller\API;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api/auth/")
 *
 * @SWG\Tag(name="auth")
 */
class AuthController extends AbstractController
{
    /**
     * @Route("login", methods={"POST"}, name="api_auth_login")
     *
     * @SWG\Parameter(
     *    name="form",
     *    in="body",
     *    description="Login and password authorization",
     *    @Model(type=\App\Form\Type\Api\Auth\LoginType::class)
     *),
     *
     * @SWG\Response(
     *     response="200",
     *     description="jwt",
     *     @SWG\Schema(
     *           type="object",
     *           @SWG\Property(property="jwt", type="string"),
     *     ),
     * )
     * @SWG\Response(
     *     response="404",
     *     description="jwt",
     *     @SWG\Schema(
     *           type="object",
     *           @SWG\Property(property="message", type="string"),
     *     ),
     * )
     * @SWG\Tag(name="auth")
     */
    public function loginAction(JWTTokenManagerInterface $JWTToken, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em, Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        /** @var User $user */
        $user = $em->getRepository(User::class)->findOneBy(['username' => $username]);

        if ($user && $passwordEncoder->isPasswordValid($user, $password)) {
            return $this->json(['jwt' => $JWTToken->create($user)]);
        }
        return $this->json(['message' => 'incorrect username or password'], 404);
    }
}