<?php

namespace Danupe\Plugin\Text\Controllers;
use Danupe\Core\Classes\Controller;
use Danupe\Plugin\User\Classes\Validate;
use Danupe\Plugin\Text\Models\Text;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
class TextController extends Controller
{
    public function index()
    {
        $textData = new Text();
        $textData = $textData->orderBy(['id' => 'asc'])->all(['`id`', '`key`', '`language`', '`text`']);

        foreach ($textData as $key => $value) {
            $texts[$key]['id'] = $value['id'];
            $texts[$key]['key'] = $value['key'];
            $text = $value['text'];
            if(strlen($text) > 50) {
                $texts[$key]['text'] =  substr($text, 0, 50) . '...';
            }else {
                $texts[$key]['text'] = $text;
            }
            $texts[$key]['language'] = $value['language'];
        }

        danupe()->view()->get('plugin-text', 'texts/index', ['texts' => $texts, 'title' => 'texts']);

    }

    public function edit($args)
    {
        $text = new Text();
        $text = $text->first(danupe()->data()->get($args, 'id'));
        danupe()->view()->get('plugin-text', 'texts/edit', ['text' => $text, 'title' => 'Edit Text']);

    }

    public function update_post()
    {
        $validator = new Validate();

        $id = danupe()->input()->get('id');
        $rules = [];
        $rules = array_merge($rules, [
            'text' => 'required|string',
            // Enforce 2-char language code to match DB schema VARCHAR(2)
            'language' => 'required|min:2|max:2'
        ]);

        $validationResult = $validator->validate(danupe()->input()->all(), $rules);

        $data = danupe()->input()->only(['key', 'text', 'language', 'id']);

        // Fallback: if language missing (should be caught by validation) use session or default
        if(empty(danupe()->data()->get($data,'language'))){
            $sessionLang = substr((string) danupe()->session()->get('language','en'),0,2);
            $data['language'] = $sessionLang ?: 'en';
        }
        // Hard sanitize to 2 chars to avoid SQLSTATE[22001]
        $data['language'] = substr(strtolower($data['language']),0,2);

        if ($validationResult) {
            $text = new Text();
            $text->update($data);
            return $this->redirectWithSuccess('/' . danupe()->env()->get('DANUPE_ADMIN_PREFIX') . '/texts/edit/' . $id, 'Text updated successfully');
        } else {
            return $this->redirectWithErrors('/' . danupe()->env()->get('DANUPE_ADMIN_PREFIX') . '/texts/edit/' . $id, $validator->getErrors());
        }
    }

    public function create()
    {
        danupe()->view()->get('plugin-text', 'texts/create', ['title' => 'Create']);

    }

    public function create_post()
    {

        $validator = new Validate();
        $rules = [
            'key' => 'text|string',
            'text' => 'text|string',
            // Add language validation (DB column is VARCHAR(2) NOT NULL)
            'language' => 'required|min:2|max:2'
        ];

        $validationResult = $validator->validate(danupe()->input()->all(), $rules);


        $data = danupe()->input()->only(['key','text', 'language', 'id']);

        // If language not provided, pull from session or default to 'en'
        if(empty(danupe()->data()->get($data,'language'))){
            $sessionLang = substr((string) danupe()->session()->get('language','en'),0,2);
            $data['language'] = $sessionLang ?: 'en';
        }
        // Sanitize length & casing proactively
        $data['language'] = substr(strtolower($data['language']),0,2);

        if ($validationResult) {
            $user = new Text();
            $user->save($data);
            return $this->redirectWithSuccess('/' . danupe()->env()->get('DANUPE_ADMIN_PREFIX') . '/texts/create', 'Text created successfully');
        } else {
            return $this->redirectWithErrors('/' . danupe()->env()->get('DANUPE_ADMIN_PREFIX') . '/texts/create', $validator->getErrors());
        }
    }

    public function delete_post()
    {
        $validator = new Validate();
        $rules = [
            'id' => 'required|integer',
        ];
        $validationResult = $validator->validate(danupe()->input()->only(['id']), $rules);
        $id = danupe()->data()->get(danupe()->input()->only(['id']), 'id');

        if ($validationResult) {
            $text = new Text();
            $text->delete($id);
            return $this->redirectWithSuccess('/' . danupe()->env()->get('DANUPE_ADMIN_PREFIX') . '/texts', 'Text deleted successfully');
        } else {
            return $this->redirectWithErrors('/' . danupe()->env()->get('DANUPE_ADMIN_PREFIX') . '/texts/edit/' . $id, $validator->getErrors());
        }
    }
}
