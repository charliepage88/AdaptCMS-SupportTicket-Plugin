{{ tinymce.simple }}

{{ setTitle('Add Ticket') }}

{{ addCrumb('Tickets', url('support_ticket_index')) }}
{{ addCrumb('New Ticket', null) }}

{{ form.create('Ticket', array('type' => 'file', 'class' => 'well admin-validate')) }}
	<h2>Submit Ticket</h2>
	
	{{ form.input('full_name', array(
		'type' => 'text', 
		'class' => 'required'
	)) }}
	{{ form.input('email', array(
		'type' => 'text', 
		'class' => 'required email'
	)) }}

	{{ form.input('subject', array(
		'type' => 'text', 
		'class' => 'required'
	)) }}
	{{ form.input('category_id', array('class' => 'required')) }}
	{{ form.input('message', array('rows' => 15, 'style' => 'width:500px', 'class' => 'required')) }}

	{{ form.input('priority', array('type' => 'text', 'class' => 'required')) }}

	{% if not empty(captcha) %}
		<div id="captcha">
			{{ captcha.form() }}
		</div>
	{% endif %}

{{ form.end(array(
	'label' => 'Submit',
	'class' => 'btn btn-primary'
)) }}