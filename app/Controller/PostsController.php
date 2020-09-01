<?php
class PostsController extends AppController
{   
	public $helpers = array('Html', 'Form');

	public function index() {
        $this->set('posts', $this->Post->find('all'));
    }

    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $post = $this->Post->findById($id);
        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->set('post', $post);
    }
# if the HTTP method of the request was POST, it tries to save the data using the Post model. If for some reason it doesn’t save, it just renders the view. This gives us a chance to show the user validation errors or other warnings.
    public function add() {
    	# In this case, post refers to the request method, POST method (instead of GET, PUT...)
		# check if the request is a "POST" request       
        if ($this->request->is('post')) {
            $this->Post->create();
            if ($this->Post->save($this->request->data)) {
            	# Set a message to a session variable to be displayed on the page after redirection. 
                $this->Flash->success(__('Your post has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(__('Unable to add your post.'));
        }
    }
}