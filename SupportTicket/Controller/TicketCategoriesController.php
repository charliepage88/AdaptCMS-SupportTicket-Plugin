<?php
/**
 * Class TicketCategoriesController
 *
 * @property TicketCategory $TicketCategory
 */
class TicketCategoriesController extends SupportTicketAppController
{
    /**
    * Name of the Controller, 'TicketCategories'
    */
	public $name = 'TicketCategories';

    /**
    * array of permissions for this page
    */
	private $permissions;

    /**
    * In this beforeFilter we will get the permissions to be used in the view files
    *
    * Also set to the view a list of ticket categories for category order
    */
	public function beforeFilter()
	{
		parent::beforeFilter();
	
		$this->permissions = $this->getPermissions();
	}

    /**
    * Returns a paginated index of Ticket Categories
    *
    * @return array of categories data
    */
	public function admin_index()
	{
		$conditions = array();

		if (isset($this->request->named['trash']))
	        $conditions['TicketCategory.only_deleted'] = true;

	    if ($this->permissions['any'] == 0)
	    	$conditions['User.id'] = $this->Auth->user('id');

        $this->Paginator->settings = array(
            'conditions' => $conditions,
            'contain' => array(
            	'User'
            )
        );
        
		$this->request->data = $this->Paginator->paginate('TicketCategory');
	}

    /**
    * Returns nothing before post
    *
    * On POST, returns error flash or success flash and redirect to index on success
    *
    * @return mixed
    */
	public function admin_add()
	{
        if (!empty($this->request->data))
        {
        	$this->TicketCategory->create();

    		$this->request->data['TicketCategory']['user_id'] = $this->Auth->user('id');

            if ($this->TicketCategory->save($this->request->data))
            {
                $this->Session->setFlash('Your ticket category has been added.', 'flash_success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Unable to add your ticket category.', 'flash_error');
            }
        }
	}

    /**
    * Before POST, sets request data to form
    *
    * After POST, flash error or flash success and redirect to index
    *
    * @param integer $id ID of the database entry, redirect to index if no permissions
    * @return array of ticket category data
    */
	public function admin_edit($id)
	{
      	$this->TicketCategory->id = $id;

	    if (!empty($this->request->data))
	    {
	    	$this->request->data['TicketCategory']['user_id'] = $this->Auth->user('id');

	        if ($this->TicketCategory->save($this->request->data))
	        {
	            $this->Session->setFlash('Your ticket category has been updated.', 'flash_success');
	            $this->redirect(array('action' => 'index'));
	        } else {
	            $this->Session->setFlash('Unable to update your ticket category.', 'flash_error');
	        }
	    }

		$this->request->data = $this->TicketCategory->findById($id);
		$this->hasAccessToItem($this->request->data);
	}

    /**
    * If item has no delete time, then initial deletion is to the trash area (making it in-active on site, if applicable)
    *
    * But if it has a deletion time, meaning it is in the trash, deleting it the second time is permanent.
    *
    * @param integer $id ID of the database entry, redirect to index if no permissions
    * @param string $title Title of this entry, used for flash message
    * @return void
    */
	public function admin_delete($id, $title = null)
	{
	    $this->TicketCategory->id = $id;

		$data = $this->TicketCategory->findById($id);
		$this->hasAccessToItem($data);

		$permanent = $this->TicketCategory->remove($data);

		$this->Session->setFlash('The ticket category `'.$title.'` has been deleted.', 'flash_success');

		if ($permanent)
		{
			$this->redirect(array('action' => 'index', 'trash' => 1));
		} else {
			$this->redirect(array('action' => 'index'));
		}
	}

    /**
    * Restoring an item will take an item in the trash and reset the delete time
    *
    * This makes it live wherever applicable
    *
    * @param integer $id ID of database entry, redirect if no permissions
    * @param string $title Title of this entry, used for flash message
    * @return void
    */
	public function admin_restore($id, $title = null)
	{
	    $this->TicketCategory->id = $id;

		$data = $this->TicketCategory->findById($id);
		$this->hasAccessToItem($data);

	    if ($this->TicketCategory->restore())
	    {
	        $this->Session->setFlash('The ticket category `'.$title.'` has been restored.', 'flash_success');
	        $this->redirect(array('action' => 'index'));
	    } else {
	    	$this->Session->setFlash('The ticket category `'.$title.'` has NOT been restored.', 'flash_error');
	        $this->redirect(array('action' => 'index'));
	    }
	}
}