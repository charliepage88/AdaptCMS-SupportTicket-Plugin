<?php
App::uses('Sanitize', 'Utility');

class TicketCategory extends SupportTicketAppModel {
	public $name = 'PluginTicketCategory';
	public $useTable = 'plugin_support_categories';

	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		)
	);

	public $hasMany = array(
        'Ticket' => array(
            'className' => 'SupportTicket.Ticket'
        )
	);

    /**
    * Our validate rules. The Category title must not be empty and must be unique.
    */
    public $validate = array(
        'title' => array(
            array(
                'rule' => 'notEmpty',
                'message' => 'Category title cannot be empty'
            ),
            array(
                'rule' => 'isUnique',
                'message' => 'Category title has already been used'
            )
        )
    );

    /**
     * @var array
     */
    public $actsAs = array(
	    'Slug',
	    'Delete'
    );
    
    /**
    * Sets the slug
    *
    * @return boolean
    */
    public function beforeSave()
    {
        $this->data = Sanitize::clean($this->data, array(
            'encode' => false,
            'remove_html' => true
        ));

        return true;
    }
}