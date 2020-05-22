<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param int $id
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function index(int $id, ProductRepository $productRepository)
    {
        // 检查商品是否存在
        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                '商品不存在：'.$id
            );
        }

        // 减库存
        $s = $productRepository->decrStock($id);

        return $this->json(['decr'=>$s]);
    }
}