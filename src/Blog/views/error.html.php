<h2><?= $this->exception->getMessage() ?></h2>
<table class="exception_table">
    <tr>
        <td><strong>Code:</strong></td>
        <td><?= $this->exception->getCode() ?></td>
    </tr>
    <tr>
        <td><strong>Message:</strong></td>
        <td><?= $this->exception->getMessage() ?></td>
    </tr>
    <tr>
        <td><strong>Type:</strong></td>
        <td><?= getType($this->exception) ?></td>
    </tr>
    <tr>
        <td><strong>File:</strong></td>
        <td><?= $this->exception->getFile() ?></td>
    </tr>
    <tr>
        <td><strong>Line:</strong></td>
        <td><?= $this->exception->getLine() ?></td>
    </tr>
</table>