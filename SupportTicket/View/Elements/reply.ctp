{{ form.create('Ticket', array(
	'url' => array(
		'action' => 'reply'
	)
)) }}
	<h3>Post Reply</h3>

	{{ form.input('full_name', array(
		'type' => 'text', 
		'class' => 'required',
		'value' => ''
	)) }}
	{{ form.input('email', array(
		'type' => 'text', 
		'class' => 'required email',
		'value' => !empty($current_user['email']) ? $current_user['email'] : ''
	)) }}

	{{ form.input('message', array(
		'class' => 'span7',
		'style' => 'height: 100%',
		'label' => 'Message',
		'required' => false,
		'value' => ''
	)) }}

	{{ form.hidden( 'parent_id', array(
		'value' => $ticket['Ticket']['id']
	)) }}
	{{ form.hidden( 'subject', array(
		'value' => $ticket['Ticket']['subject']
	)) }}
	{{ form.hidden( 'slug', array(
		'value' => $ticket['Ticket']['slug']
	)) }}
	{{ form.hidden('created', array('value' => $this->Admin->datetime() )) }}

	{% if not empty(captcha) %}
		<div id="captcha" style="margin-top: 10px;margin-bottom: 10px">
			{{ captcha.form() }}
		</div>
	{% endif %}

	{{ form.button('Post Reply <i class="icon-ok"></i>', array(
		'type' => 'submit',
		'class' => 'btn btn-info',
		'escape' => false
	)) }}
{{ form.end() }}