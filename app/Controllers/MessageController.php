<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Flash;
use App\Helpers\Validator;
use App\Models\Message;
use App\Models\User;
use App\Models\ClassModel;

class MessageController extends Controller
{
    protected Message $messages;

    public function __construct()
    {
        $this->messages = new Message();
    }

    public function inbox()
    {
        $user = current_user();
        $messages = $this->messages->inbox($user['id']);
        return $this->view('messages/inbox', compact('messages'));
    }

    public function sent()
    {
        $user = current_user();
        $messages = $this->messages->sent($user['id']);
        return $this->view('messages/inbox', ['messages' => $messages, 'sent' => true]);
    }

    public function compose()
    {
        $users = (new User())->all();
        $classes = (new ClassModel())->paginate(1, 100)['items'];
        return $this->view('messages/compose', compact('users', 'classes'));
    }

    public function send()
    {
        $validator = Validator::make($_POST)
            ->required('to_user_id', 'Alıcı seçiniz.')
            ->required('subject', 'Konu zorunludur.')
            ->required('body', 'Mesaj içeriği zorunludur.');

        if (!$validator->passes()) {
            Flash::add('error', 'Lütfen formu eksiksiz doldurun.');
            $this->back();
        }
        $user = current_user();
        $this->messages->create([
            'from_user_id' => $user['id'],
            'to_user_id' => $_POST['to_user_id'],
            'class_id' => $_POST['class_id'] ?: null,
            'subject' => $_POST['subject'],
            'body' => $_POST['body'],
            'parent_id' => $_POST['parent_id'] ?? null,
        ]);
        Flash::add('success', 'Mesaj gönderildi.');
        $this->redirect('/messages');
    }

    public function thread($id)
    {
        $user = current_user();
        $thread = $this->messages->thread((int)$id, $user['id']);
        if (!$thread) {
            Flash::add('error', 'Mesaj bulunamadı.');
            $this->redirect('/messages');
        }
        $this->messages->markAsRead((int)$id, $user['id']);
        return $this->view('messages/thread', compact('thread'));
    }
}
