<?php

declare(strict_types=1);

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

final class AuctionSniperEndToEndTest
{
    private FakeAuctionServer $auction;
    private ApplicationRunner $application;

    public function _before(AcceptanceTester $I): void
    {
        $this->auction = new FakeAuctionServer("item-54321");
        $this->application = new ApplicationRunner();
    }

    public function sniperJoinsAuctionUntilAuctionCloses(AcceptanceTester $I): void {
        $this->auction->startSellingItem();
        $this->application->startBiddingIn($this->auction);
        $this->auction->hasReceivedJoinRequestFromSniper();
        $this->auction->announceClosed();
        $this->application->hasShownSniperHasLostAuction();
    }

    public function _after(AcceptanceTester $I): void {
        $this->auction->stop();
        $this->application->stop();
    }
}
