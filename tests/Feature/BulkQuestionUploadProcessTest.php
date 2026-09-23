<?php

use App\Http\Controllers\Pages\Questions\BulkUpload;
use Tests\Support\PageTest;

it('processes raw mcq text into preview questions before submit', function () {
    PageTest::test(BulkUpload::class)
        ->set('rawText', '১. শব্দটির অর্থ কী? (ক) কলসি (খ) চরকি (গ) কুলফি (ঘ) বাড়ি')
        ->call('processQuestions')
        ->assertHasNoErrors()
        ->assertSet('processedQuestions.0.title', 'শব্দটির অর্থ কী?')
        ->assertSet('processedQuestions.0.options.0.option_text', 'কলসি')
        ->assertSet('processedQuestions.0.options.3.option_text', 'বাড়ি')
        ->assertSee('১. শব্দটির অর্থ কী?')
        ->assertSee('(ক) কলসি')
        ->assertSee('(ঘ) বাড়ি');
});
