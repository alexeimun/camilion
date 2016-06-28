<?php
    /**
     * @var $this CI_Loader
     */
    $this->Header(['assets' => ['camilion', 'dialogs', 'spin', 'jvalidator']], 'camilion');
?>
    <div class="starter-template">
        <h1 style="color:#099a5b;text-align: center;margin-top: 20px;"><span style="font-size: 25pt;"
                                                                             class="ion-hammer"></span>
            Camilion Code Generator
        </h1>

        <p class="lead">The simplest way to generate code without waste your time <span
                class="ion-ios-clock-outline"></span></p>
    </div>
    <div class="container" ng-app="camilionApp">
        <div ng-view=""></div>
    </div>

<?= $this->Footer() ?>