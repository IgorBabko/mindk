<?php info($this->exception->getTraceAsString()); ?>
<?=$this->exception->getMessage()?>
<table>
    <tr>
        <td><strong>Code:</strong></td>
        <td><?=$this->exception->getCode()?></td>
    </tr>
    <tr>
        <td><strong>Message:</strong></td>
        <td><?=$this->exception->getMessage()?></td>
    </tr>
    <tr>
        <td><strong>Type:</strong></td>
        <td><?=getType($this->exception)?></td>
    </tr>
    <tr>
        <td><strong>File:</strong></td>
        <td><?=$this->exception->getFile()?></td>
    </tr>
    <tr>
        <td><strong>Line:</strong></td>
        <td><?=$this->exception->getLine()?></td>
    </tr>
</table>

<? info($this->getStackTrace) ?>
<div class="row">
    <div role="alert" class="alert alert-danger">
        <strong><?php echo "Error {$this->code}: "; ?></strong><?= $this->message; ?>
    </div>
</div>