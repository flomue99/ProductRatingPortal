<?php

namespace Presentation\Controllers;

class Ratings extends \Presentation\MVC\Controller
{
    public function __construct(private \Application\SignedInUserQuery            $signedInUserQuery,
                                private \Application\RatingsForUserQuery          $ratingsQuery,
                                private \Application\ProductQuery                 $productQuery,
                                private \Application\CreateRatingCommand          $createRatingCommand,
                                private \Application\UpdateRatingCommand          $updateRatingCommand,
                                private \Application\RatingForUserAndProductQuery $ratingForUserAndProductQuery,
                                private \Application\Services\RatingsService      $ratingsService,
                                private \Application\DeleteRatingCommand          $deleteRatingCommand)
    {
    }

    public function GET_Index(): \Presentation\MVC\ActionResult
    {
        $user = $this->signedInUserQuery->execute();
        return $this->view('userRatings', [
            'user' => $user,
            'options' => true,
            'ratings' => $this->ratingsQuery->execute($user->id),
            'context' => $this->getRequestUri(),
        ]);
    }

    public function GET_Update(): \Presentation\MVC\ActionResult
    {
        $user = $this->signedInUserQuery->execute();
        if ($user == null) {
            return $this->View('notAuthorized',
            [
                'user' => $user,
            ]);
        }

        $pid = $this->getParam('pid');
        return $this->view('editRating', [
            'user' => $user,
            'product' => $this->productQuery->execute($pid),
            'rating' => $this->ratingForUserAndProductQuery->execute($user->id, $pid),
        ]);

    }


    public function GET_Create(): \Presentation\MVC\ActionResult
    {
        $user = $this->signedInUserQuery->execute();
        if ($user == null) {
            return $this->View('notAuthorized',
            [
                'user' => $user,
            ]);
        }

        return $this->view('newRating', [
            'user' => $user,
            'product' => $this->tryGetParam('pid', $pid) ? $this->productQuery->execute($pid) : null,
            'comment' => '',
            'rating' => '',
        ]);
    }

    public function POST_Update(): \Presentation\MVC\ActionResult
    {
        $user = $this->signedInUserQuery->execute();
        if ($user == null) {
            return $this->View('notAuthorized',
                [
                    'user' => $user,
                ]
            );
        }

        $result = $this->updateRatingCommand->execute(
            $this->getParam('rid'),
            $this->getParam('pid'),
            $this->getParam('rat'),
            $this->getParam('com')
        );

        if ($result != 0) {
            $errors = [];

            if ($result & \Application\CreateRatingCommand::ERROR_RATING_GRADE_REQUIRED) {
                $errors[] = 'Rating grade cannot be empty!';
            }

            if ($result & \Application\CreateRatingCommand::ERROR_RATING_GRADE_MUST_BE_INT) {
                $errors[] = 'Rating grade must be an integer between 1 and 5!';
            }

            if ($result & \Application\CreateRatingCommand::ERROR_USER_NOT_AUTHENTICATED) {
                $errors[] = 'You are not able to perfom this action!';
            }

            if (sizeof($errors) == 0) {
                $errors[] = 'An error occurred. Please try again.';
            }

            return $this->view('editRating', [
                'user' => $user,
                'product' => $this->productQuery->execute($this->getParam('pid')),
                'comment' => $this->getParam('com'),
                'rating' => $this->getParam('rat'),
                'errors' => $errors,
                'context' => $this->getRequestUri(),
            ]);

        }
        return $this->redirect('Ratings', 'Index');
    }

    public function POST_CREATE(): \Presentation\MVC\ActionResult
    {
        $user = $this->signedInUserQuery->execute();
        if ($user == null) {
            return $this->View('notAuthorized',
                [
                    'user' => $user,
                ]);
        }

        $result = $this->createRatingCommand->execute(
            -1,
            $this->getParam('pid'),
            $this->getParam('rat'),
            $this->getParam('com')
        );

        if ($result != 0) {
            $errors = [];

            if ($result & \Application\CreateRatingCommand::ERROR_RATING_GRADE_REQUIRED) {
                $errors[] = 'Rating grade cannot be empty!';
            }

            if ($result & \Application\CreateRatingCommand::ERROR_RATING_GRADE_MUST_BE_INT) {
                $errors[] = 'Rating grade must be an integer between 1 and 5!';
            }

            if ($result & \Application\CreateRatingCommand::ERROR_USER_NOT_AUTHENTICATED) {
                $errors[] = 'You are not able to perfom this action!';
            }

            if (sizeof($errors) == 0) {
                $errors[] = 'An error occurred. Please try again.';
            }

            return $this->view('newRating', [
                'user' => $user,
                'product' => $this->tryGetParam('pid', $pid) ? $this->productQuery->execute($pid) : null,
                'comment' => $this->getParam('com'),
                'rating' => $this->getParam('rat'),
                'errors' => $errors,
                'context' => $this->getRequestUri(),
            ]);
        }
        return $this->redirect('Details', 'Index', ['pid' => $this->getParam('pid')]);
    }

    public function POST_Delete(): \Presentation\MVC\ActionResult
    {
        $user = $this->signedInUserQuery->execute();
        if ($user == null) {
            return $this->View('notAuthorized',
                [
                    'user' => $user,
                ]);
        }

        $this->deleteRatingCommand->execute($this->getParam('rid'));
        return $this->redirect('Ratings', 'Index');
    }
}