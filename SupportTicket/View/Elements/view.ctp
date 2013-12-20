<div class="span10 well{% if !$ticket['reply'] %} no-marg-left{% endif %}" id="ticket-{{ ticket['Ticket']['id'] }}">
	<div class="header">
		<h5>
			{% if not empty(ticket['Ticket']['full_name']) %}
				{{ ticket['Ticket']['full_name'] }}
			{% endif %}
			{% if not empty(ticket['User']['username']) %}
				<a href="{{ url('user_profile', $ticket) }}">
					({{ ticket['User']['username'] }})
				</a>
			{% else %}
				(Guest)
			{% endif %}
			 @
			{{ time(ticket, 'words', 'created') ?>
		</h5>

		{% if not $ticket['reply'] %}
			<h3>
				{{ ticket['Ticket']['subject'] }}
			</h3>
		{% endif %}
	</div>

	<div class="body">
		{{ ticket['Ticket']['message'] }}
	</div>
</div>

<div class="clearfix"></div>