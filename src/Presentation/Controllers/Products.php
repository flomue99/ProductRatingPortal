<?php

namespace Presentation\Controllers;

class Products extends \Presentation\MVC\Controller
{
    public function __construct(
        private \Application\CreateProductCommand          $createProductCommand,
        private \Application\UpdateProductCommand          $updateProductCommand,
        private \Application\ProductsForFilterQuery        $productsForFilterQuery,
        private \Application\ProductsForUserAndFilterQuery $productsForUserAndFilterQuery,
        private \Application\ProductQuery                  $productQuery,
        private \Application\SignedInUserQuery             $signedInUserQuery)
    {
    }

    public function GET_Index(): \Presentation\MVC\ActionResult
    {
        $displayAllProducts = $this->tryGetParam('dispAll', $displayAllProducts) ? $displayAllProducts : true;
        $searchString = $this->tryGetParam('ss', $searchString) ? $searchString : '';
        if ($displayAllProducts) {
            $products = $this->productsForFilterQuery->execute($searchString);
        } else {
            $products = $this->productsForUserAndFilterQuery->execute($searchString);
        }
        return $this->view('products', [
            'user' => $this->signedInUserQuery->execute(),
            'displayAllProducts' => $displayAllProducts,
            'searchString' => $searchString,
            'products' => $products,
            'context' => $this->getRequestUri(),
        ]);
    }

    public function GET_UPDATE(): \Presentation\MVC\ActionResult
    {
        $user = $this->signedInUserQuery->execute();
        $product = $this->productQuery->execute($this->getParam('pid'));
        if ($user == null) {
            return $this->View('notAuthorized',
                [
                    'user' => $user,
                ]);
        }
        return $this->view('editProduct', [
            'user' => $user,
            'product' => $product,
        ]);
    }

    public function POST_Update(): \Presentation\MVC\ActionResult
    {
        $user = $this->signedInUserQuery->execute();
        if ($user == null) {
            return $this->View('notAuthorized',
                [
                    'user' => $user,
                ]);
        }

        $pid = $this->getParam('pid');
        $name = $this->getParam('name');
        $manu = $this->getParam('manu');
        $desc = $this->getParam('desc');


        $result = $this->updateProductCommand->execute($pid, $name, $manu, $desc);

        if ($result != 0) {
            $errors = [];

            if ($result & \Application\CreateProductCommand::ERROR_NAME_REQUIRED) {
                $errors[] = 'Name cannot be empty!';
            }
            if ($result & \Application\CreateProductCommand::ERROR_MANUFACTURER_REQUIRED) {
                $errors[] = 'Manufacturer cannot be empty!';
            }
            if ($result & \Application\CreateProductCommand::ERROR_USER_NOT_AUTHENTICATED) {
                $errors[] = 'You are not able to perfom this action!';
            }
            if (sizeof($errors) == 0) {
                $errors[] = 'An error occurred. Please try again.';
            }

            return $this->view('editProduct', [
                'user' => $user,
                'product' => $this->productQuery->execute($pid),
                'name' => $name,
                'manufacturer' => $manu,
                'description' => $desc,
                'errors' => $errors,
                'context' => $this->getRequestUri(),
            ]);
        }
        return $this->redirect('Details', 'Index', ['pid' => $this->getParam('pid')]);
    }

    public function GET_Create(): \Presentation\MVC\ActionResult
    {
        //check if user is signed in, only perform action if user is signed in
        $user = $this->signedInUserQuery->execute();
        if ($user == null) {
            return $this->View('notAuthorized',
                [
                    'user' => $user,
                ]);
        }
        return $this->view('newProduct', [
            'user' => $user,
            'name' => '',
            'manufacturer' => '',
            'description' => '',
        ]);
    }

    public function POST_Create(): \Presentation\MVC\ActionResult
    {
        $user = $this->signedInUserQuery->execute();
        if ($user == null) {
            return $this->View('notAuthorized',
                [
                    'user' => $user,
                ]);
        }

        $result = $this->createProductCommand->execute(
            -1, // -1 means create new product
            $this->getParam('name'),
            $this->getParam('manu'),
            $this->getParam('desc')
        );

        if ($result != 0) {
            $errors = [];

            if ($result & \Application\CreateProductCommand::ERROR_NAME_REQUIRED) {
                $errors[] = 'Name cannot be empty!';
            }
            if ($result & \Application\CreateProductCommand::ERROR_MANUFACTURER_REQUIRED) {
                $errors[] = 'Manufacturer cannot be empty!';
            }
            if ($result & \Application\CreateProductCommand::ERROR_USER_NOT_AUTHENTICATED) {
                $errors[] = 'You are not able to perfom this action!';
            }
            if (sizeof($errors) == 0) {
                $errors[] = 'An error occurred. Please try again.';
            }

            return $this->view('newProduct', [
                'user' => $user,
                'name' => $this->getParam('name'),
                'manufacturer' => $this->getParam('manu'),
                'description' => $this->getParam('desc'),
                'errors' => $errors,
                'context' => $this->getRequestUri(),
            ]);
        }
        return $this->redirect('Products', 'Index');
    }

}