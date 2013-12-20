{{ tinymce.simple }}

{{ setTitle('Ticket - ' . $ticket['Ticket']['subject']) }}

{{ addCrumb('Tickets', url('support_ticket_index')) }}
{{ addCrumb('View Ticket', null) }}

<h2>
	Viewing Ticket

	{% if not empty(ticket['TicketCategory']['title']) %}
		<small>
			{{ ticket['TicketCategory']['title'] }}
		</small>
	{% endif %}
</h2>

{{ partial('SupportTicket.view', array('ticket' => $ticket)) }}

{% if not empty(ticket['Replies']) %}
	{% loop row in ticket['Replies'] %}
		{{ partial('SupportTicket.view', array('ticket' => $row)) }}
	{% endloop %}
{% endif %}

{{ partial('SupportTicket.reply', array('ticket' => $ticket)) }}