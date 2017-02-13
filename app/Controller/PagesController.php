<?php

App::uses('AppController', 'Controller');

class PagesController extends AppController {

    public $components = array('Flash');

    function beforeRender() {
        parent::beforeRender();
        $this->importStickers();
    }

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    public function display() {
        $path = func_get_args();

        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        $page = $subpage = $title_for_layout = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        if (!empty($path[$count - 1])) {
            $title_for_layout = Inflector::humanize($path[$count - 1]);
        }
        $this->set(compact('page', 'subpage', 'title_for_layout'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingViewException $e) {
            if (Configure::read('debug')) {
                throw $e;
            }
            throw new NotFoundException();
        }
    }

    public function home() {
        $this->layout = 'home';
    }

    public function about() {
        
    }

    public function help() {
        
    }

    public function rankings() {
        $members = $this->Member->find('all');
        $this->set('members', $members);

        $maxiTableau = array(
            "Tennis" => array('Aces' => 'Aces', 'Smashes' => 'Smashes', 'Volleys' => 'Volleys'),
            "Beer Pong" => array('Bounce shots' => 'Bounce shots', 'Normal shots' => 'Normal shots', 'Blown balls' => 'Blown balls'),
            "Quidditch" => array('Golden Snitch catched' => 'Golden Snitch catched', 'Quaffle scored' => 'Quaffle scored', 'Bludgers knocked' => 'Bludgers knocked'),
            "Cricket" => array('Full toss' => 'Full toss', 'Caught out' => 'Caught out', 'Penalty' => 'Penalty'),
            "Soccer" => array('Goals' => 'Goals', 'Passes' => 'Passes', 'Shots' => 'Shots'),
            "100m hurdles" => array('Seconds' => 'Seconds', 'Steps' => 'Steps', 'Hurdles jumped' => 'Hurdles jumped'),
        );

        $maxiTableau['Tennis']['Aces'] = $this->Log->query("SELECT member_id, SUM(log_value), log_type FROM logs WHERE log_type='Aces' GROUP BY member_id ORDER BY SUM(log_value) DESC;");
        $maxiTableau['Tennis']['Smashes'] = $this->Log->query("SELECT member_id, SUM(log_value), log_type FROM logs WHERE log_type='Smashes' GROUP BY member_id ORDER BY SUM(log_value) DESC;");
        $maxiTableau['Tennis']['Volleys'] = $this->Log->query("SELECT member_id, SUM(log_value), log_type FROM logs WHERE log_type='Volleys' GROUP BY member_id ORDER BY SUM(log_value) DESC;");

        $maxiTableau['Beer Pong']['Bounce shots'] = $this->Log->query("SELECT member_id, SUM(log_value), log_type FROM logs WHERE log_type='Bounce shots' GROUP BY member_id ORDER BY SUM(log_value) DESC;");
        $maxiTableau['Beer Pong']['Normal shots'] = $this->Log->query("SELECT member_id, SUM(log_value), log_type FROM logs WHERE log_type='Normal shots' GROUP BY member_id ORDER BY SUM(log_value) DESC;");
        $maxiTableau['Beer Pong']['Blown balls'] = $this->Log->query("SELECT member_id, SUM(log_value), log_type FROM logs WHERE log_type='Blown balls' GROUP BY member_id ORDER BY SUM(log_value) DESC;");

        $maxiTableau['Quidditch']['Golden Snitch catched'] = $this->Log->query("SELECT member_id, SUM(log_value), log_type FROM logs WHERE log_type='Golden Snitch catched' GROUP BY member_id ORDER BY SUM(log_value) DESC;");
        $maxiTableau['Quidditch']['Quaffle scored'] = $this->Log->query("SELECT member_id, SUM(log_value), log_type FROM logs WHERE log_type='Quaffle scored' GROUP BY member_id ORDER BY SUM(log_value) DESC;");
        $maxiTableau['Quidditch']['Bludgers knocked'] = $this->Log->query("SELECT member_id, SUM(log_value), log_type FROM logs WHERE log_type='Bludgers knocked' GROUP BY member_id ORDER BY SUM(log_value) DESC;");

        $maxiTableau['Cricket']['Full toss'] = $this->Log->query("SELECT member_id, SUM(log_value), log_type FROM logs WHERE log_type='Full toss' GROUP BY member_id ORDER BY SUM(log_value) DESC;");
        $maxiTableau['Cricket']['Caught out'] = $this->Log->query("SELECT member_id, SUM(log_value), log_type FROM logs WHERE log_type='Caught out' GROUP BY member_id ORDER BY SUM(log_value) DESC;");
        $maxiTableau['Cricket']['Penalty'] = $this->Log->query("SELECT member_id, SUM(log_value), log_type FROM logs WHERE log_type='Penalty' GROUP BY member_id ORDER BY SUM(log_value) DESC;");

        $maxiTableau['Soccer']['Goals'] = $this->Log->query("SELECT member_id, SUM(log_value), log_type FROM logs WHERE log_type='Goals' GROUP BY member_id ORDER BY SUM(log_value) DESC;");
        $maxiTableau['Soccer']['Passes'] = $this->Log->query("SELECT member_id, SUM(log_value), log_type FROM logs WHERE log_type='Passes' GROUP BY member_id ORDER BY SUM(log_value) DESC;");
        $maxiTableau['Soccer']['Shots'] = $this->Log->query("SELECT member_id, SUM(log_value), log_type FROM logs WHERE log_type='Shots' GROUP BY member_id ORDER BY SUM(log_value) DESC;");

        $maxiTableau['100m hurdles']['Seconds'] = $this->Log->query("SELECT member_id, SUM(log_value), log_type FROM logs WHERE log_type='Seconds' GROUP BY member_id ORDER BY SUM(log_value) DESC;");
        $maxiTableau['100m hurdles']['Steps'] = $this->Log->query("SELECT member_id, SUM(log_value), log_type FROM logs WHERE log_type='Steps' GROUP BY member_id ORDER BY SUM(log_value) DESC;");
        $maxiTableau['100m hurdles']['Hurdles jumped'] = $this->Log->query("SELECT member_id, SUM(log_value), log_type FROM logs WHERE log_type='Hurdles jumped' GROUP BY member_id ORDER BY SUM(log_value) DESC;");

        $this->set('maxiTableau', $maxiTableau);
    }

    public function contact() {
        if ($this->request->is('post')) {
            $this->Contact->create();
            if ($this->Contact->sendMessage($this->request->data['Contact'])) {
                $this->Flash->success('Email successfully sent !');
                $this->request->data = array();
            } else {
                $this->Flash->error('Please correct form errors');
            }
        }
    }

    public function download() {
        var_dump('AQUIO');
        $this->response->file(WWW_ROOT . DS . 'files' . DS . 'version.log', array('download' => true, 'name' => 'Version.log'));
        return $this->response;
    }

    public function stickers() {
        $stickers = $this->Sticker->find('all');
        $this->set('stickers', $stickers);
        $this->set('test', "TEST");
        $this->set('members', $this->Member->find('all'));
    }

    function importStickers() {
        $file = fopen('../webroot/files/stickers.csv', 'r');
        
        if ($file) {
            while (($data = fgetcsv($file, 1000, ';')) !== False) {
                $sticker = array('name' => $data[0], 'description' => $data[1]);
                if (!$this->Sticker->find('first', array('conditions' => array('Sticker.name' => $sticker['name'])))) {
                    $this->Sticker->create();
                    $this->Sticker->save($sticker, true, array('name', 'description'));
                }
            }
        }
        fclose($file);
    }

}
