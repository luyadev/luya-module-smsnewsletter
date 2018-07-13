<?php

use luya\admin\ngrest\aw\CallbackFormWidget;

/**
 * SmsActiveWindow Index View.
 *
 * @var $this \luya\admin\ngrest\base\ActiveWindowView
 * @var $model \luya\admin\ngrest\base\NgRestModel
 */
?>
<script>
zaa.bootstrap.register('SmsController', ['$scope', function($scope) {
    $scope.list = [];
    $scope.openLogMessage = function(id) {
        $scope.$parent.sendActiveWindowCallback('load-message-log', {id:id}).then(function(response) {
            $scope.list = response.data;
        });
    };
}]);
</script>
<div class="row" ng-controller="SmsController">
    <div class="col-md-6">
        <p class="lead">Recipients</p>
        <ul class="list-group">
            <?php foreach ($model->persons as $person): ?>
            <li class="list-group-item"><?= $person->firstname; ?> <?= $person->lastname; ?> (<?= $person->phone; ?>)</li>
            <?php endforeach; ?>
        </ul>

        <p class="lead mt-5">Logs</p>
        <div class="row">
            <div class="col">
                <ul class="list-group">
                <?php foreach ($model->logMessages as $log): ?>
                    <a class="list-group-item list-group-item-action" ng-click="openLogMessage(<?= $log->id; ?>)"><?= date("d.m.Y", $log->timestamp); ?> <small><?= $log->message; ?></small></a>
                <?php endforeach; ?>
                </ul>
            </div>
            <div class="col" ng-show="list.length > 0">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Person</th>
                            <th>Delivery Status</th>
                            <th>Created</th>
                            <th>Notification Date</th>
                        </tr>
                    </thead>
                    <tr ng-repeat="status in list">
                        <td>{{ status.person.firstname}} {{status.person.lastname}}</td>
                        <td>{{ status.tracking.deliveryStatus }}</td>
                        <td>{{ status.log.timestamp }}</td>
                        <td>{{ status.tracking.notificationDate }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
    </div>
    <div class="col-md-6">
        <p class="lead">Send message</p>
        <?php $form = CallbackFormWidget::begin(['callback' => 'send', 'buttonValue' => 'Send', 'options' => ['reloadWindowOnSuccess' => true]]); ?>
        <?= $form->field('origin', 'Origin')->textInput(); ?>
        <?= $form->field('message', 'Message')->textarea(); ?>
        <?php $form::end(); ?>
    </div>
</div>