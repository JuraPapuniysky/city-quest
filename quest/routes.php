<?php
/** @var \PsrFramework\Http\Application $app */

//QuestController
$app->get('quest', '/api/v1/quest/{uuid}', [\Quest\Controllers\QuestController::class, 'quest'], true);
$app->get('quests', '/api/v1/quests', [\Quest\Controllers\QuestController::class, 'quests'], true);
$app->post('questCreate', '/api/v1/quest', [\Quest\Controllers\QuestController::class, 'create'], true);
$app->put('questUpdate', '/api/v1/quest/{uuid}', [\Quest\Controllers\QuestController::class, 'update'], true);
$app->delete('questDelete', '/api/v1/quest/{uuid}', [\Quest\Controllers\QuestController::class, 'delete'], true);
$app->get('questionTypes', '/api/v1/quest/question-types/', [\Quest\Controllers\QuestController::class, 'questionTypes'], true);
//QuestQuestionController
$app->get('questQuestion', '/api/v1/question/{uuid}', [\Quest\Controllers\QuestQuestionController::class, 'question'], true);
$app->get('quests', '/api/v1/questions/{questUuid}', [\Quest\Controllers\QuestQuestionController::class, 'questions'], true);
$app->post('questionCreate', '/api/v1/question', [\Quest\Controllers\QuestQuestionController::class, 'create'], true);
$app->put('questionUpdate', '/api/v1/question/{uuid}', [\Quest\Controllers\QuestQuestionController::class, 'update'],true);
$app->delete('questionDelete', '/api/v1/question/{uuid}', [\Quest\Controllers\QuestQuestionController::class, 'delete'], true);
