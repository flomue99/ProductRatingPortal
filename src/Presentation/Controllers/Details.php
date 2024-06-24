<?php

namespace Presentation\Controllers;

class Details extends \Presentation\MVC\Controller
{
    public function __construct(private \Application\SignedInUserQuery       $signedInUserQuery,
                                private \Application\RatingsForProductQuery  $ratingQuery,
                                private \Application\ProductQuery            $productQuery,
                                private \Application\Services\RatingsService $ratingsService)
    {
    }

    public function GET_Index(): \Presentation\MVC\ActionResult
    {
        $user = $this->signedInUserQuery->execute();
        if ($user == null) {
            $ratingFormUserExists = false;
        }
        else{
            $ratingFormUserExists = $this->ratingsService->ratingForUserAndProductExits($user->id, $this->getParam('pid'));
        }
        return $this->view('details',
            [
                'user' => $user,
                'ratingFromUserExists' => $ratingFormUserExists,
                'product' => $this->tryGetParam('pid', $pid) ? $this->productQuery->execute($pid) : null,
                'ratings' => $this->tryGetParam('pid', $pid) ? $this->ratingQuery->execute($pid) : null,
                'context' => $this->getRequestUri(),
            ]);
    }
}