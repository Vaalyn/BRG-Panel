<?php

return [
	'admin' => '\Vaalyn\AuthorizationService\Authorizer\AdminAuthorizer',
	'authorizationToken' => '\Vaalyn\AuthorizationService\Authorizer\AuthorizationTokenAuthorizer',
	'bestOfVoting' => '\BRG\Panel\Service\Authorizer\BestOfVoting\BestOfVotingAuthorizer',
	'history' => '\BRG\Panel\Service\Authorizer\History\HistoryAuthorizer',
	'statistic' => '\BRG\Panel\Service\Authorizer\Statistic\StatisticAuthorizer',
];
