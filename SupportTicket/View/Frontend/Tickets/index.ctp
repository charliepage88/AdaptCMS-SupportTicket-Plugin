<h1>Tickets</h1>

{% if $this->Admin->hasPermission($permissions['related']['tickets']['add']) %}
    <div class="pull-right admin-edit-options">
	    <a href="{{ url('support_ticket_add') }}" class="btn btn-info">
		    Submit Ticket <i class="icon icon-plus icon-white"></i>
	    </a>
	</div>
{% endif %}

{% if empty(tickets) %}
	<p>
		There are no tickets currently submitted.
	</p>
{% else %}
	<table class="table table-striped">
		<thead>
			<tr>
				<th>{{ paginator.sort('subject') }}</th>
				<th>{{ paginator.sort('User.username', 'Submitted By') }}</th>
				<th>{{ paginator.sort('TicketCategory.title', 'Category') }}</th>
				<th class="hidden-phone"># of Replies</th>
				<th class="hidden-phone">{{ paginator.sort('created') }}</th>
			</tr>
		</thead>
		<tbody>
			{% loop ticket in tickets %}
				<tr>
					<td>
						<a href="{{ url('support_ticket_view', $ticket) }}">
							{{ ticket['Ticket']['subject'] }}
						</a>
					<td>
						{% if not empty(ticket['User']['username']) %}
							{{ ticket['User']['username'] }}
						{% else %}
							Guest
						{% endif %}
					</td>
					<td>
						{% if not empty(ticket['TicketCategory']['title']) %}
							{{ ticket['TicketCategory']['title'] }}
						{% endif %}
					</td>
					<td class="hidden-phone">
						{{ ticket['Ticket']['replies'] }}
					</td>
					<td class="hidden-phone">
						{{ time(ticket, 'F d, Y', 'created') }}
					</td>
				</tr>
			{% endloop %}
		</tbody>
	</table>

	{{ partial('pagination') }}
{% endif %}