<?php $this->Html->addCrumb('Admin', '/admin') ?>
<?php $this->Html->addCrumb('Plugins', array(
    'controller' => 'plugins', 
    'action' => 'index',
    'plugin' => false
)) ?>
<?php $this->Html->addCrumb('Ticket Categories', null) ?>

<div class="pull-left">
    <h1>Ticket Categories<?php if (!empty($this->params->named['trash'])): ?> - Trash<?php endif ?></h1>
</div>
<div class="btn-group pull-right">
  <a class="btn dropdown-toggle" data-toggle="dropdown">
    View <i class="icon-picture"></i>
    <span class="caret"></span>
  </a>
  <ul class="dropdown-menu view">
    <li>
        <?= $this->Html->link('<i class="icon-ok"></i> Active', array(
            'admin' => true, 
            'action' => 'index'
        ), array('escape' => false)) ?>
    </li>
    <li>
        <?= $this->Html->link('<i class="icon-trash"></i> Trash', array(
            'admin' => true, 
            'action' => 'index', 
            'trash' => 1
        ), array('escape' => false)) ?>
    </li>
  </ul>
</div>
<div class="clearfix"></div>

<?php if ($this->Admin->hasPermission($permissions['related']['ticket_categories']['admin_add'])): ?>
    <div class="pull-right admin-edit-options">
        <?= $this->Html->link('Add Ticket Category <i class="icon icon-plus icon-white"></i>', array('action' => 'add'), array(
            'class' => 'btn btn-info', 
            'escape' => false
        )) ?>
    </div>
<?php endif ?>

<?php if (empty($this->request->data)): ?>
    <div class="clearfix"></div>
    <div class="well">
        No Items Found
    </div>
<?php else: ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('title') ?></th>
                <th><?= $this->Paginator->sort('User.username', 'Author') ?></th>
                <th class="hidden-phone"><?= $this->Paginator->sort('created') ?></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($this->request->data as $data): ?>
                <tr>
                    <td>
                        <?php if ($this->Admin->hasPermission($permissions['related']['ticket_categories']['admin_edit'], $data['User']['id'])): ?>
                            <?= $this->Html->link($data['TicketCategory']['title'], array(
                                'action' => 'edit',
                                $data['TicketCategory']['id']
                            )) ?>
                        <?php else: ?>
                            <?= $data['TicketCategory']['title'] ?>
                        <?php endif ?>
                    </td>
                    <td>
                        <?php if ($this->Admin->hasPermission($permissions['related']['users']['profile'], $data['User']['id'])): ?>
                            <?= $this->Html->link($data['User']['username'], array(
                                'controller' => 'users',
                                'action' => 'profile',
                                $data['User']['username']
                            )) ?>
                        <?php endif ?>
                    </td>
                    <td class="hidden-phone">
                        <?= $this->Admin->time($data['TicketCategory']['created']) ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                Actions
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if (empty($this->params->named['trash'])): ?>
                                    <?php if ($this->Admin->hasPermission($permissions['related']['ticket_categories']['admin_edit'], $data['User']['id'])): ?>
                                        <li>
                                            <?= $this->Admin->edit(
                                                $data['TicketCategory']['id']
                                            ) ?>
                                        </li>
                                    <?php endif ?>
                                    <?php if ($this->Admin->hasPermission($permissions['related']['ticket_categories']['admin_delete'], $data['User']['id'])): ?>
                                        <li>
                                            <?= $this->Admin->delete(
                                                $data['TicketCategory']['id'],
                                                $data['TicketCategory']['title'],
                                                'ticket category'
                                            ) ?>
                                        </li>
                                    <?php endif ?>
                                <?php else: ?>
                                    <?php if ($this->Admin->hasPermission($permissions['related']['ticket_categories']['admin_restore'], $data['User']['id'])): ?>
                                        <li>
                                            <?= $this->Admin->restore(
                                                $data['TicketCategory']['id'],
                                                $data['TicketCategory']['title']
                                            ) ?>
                                        </li>
                                    <?php endif ?>
                                    <?php if ($this->Admin->hasPermission($permissions['related']['ticket_categories']['admin_delete'], $data['User']['id'])): ?>
                                        <li>
                                            <?= $this->Admin->delete_perm(
                                                $data['TicketCategory']['id'],
                                                $data['TicketCategory']['title'],
                                                'ticket category'
                                            ) ?>
                                        </li>
                                    <?php endif ?>
                                <?php endif ?>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
<?php endif ?>

<?= $this->element('admin_pagination') ?>