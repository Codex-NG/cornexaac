
<p>Do you really want to disband your guild? Confirm this decision with your password and click on "Submit".</p>

<form method="POST">

    <table>
        <tr class="header">
            <th colspan="2">Disband Guild</th>
        </tr>

        <tr>
            <th width="20%">Password:</th>
            <td>
                <input type="password" name="password">

                <?php if ($validator->hasError('password')): ?>
                    <em class="error"><?php echo $validator->getError('password'); ?></em>
                <?php endif; ?>
            </td>
        </tr>

        <tr class="transparent noborderpadding">
            <th></th>
            <td>
                <input type="submit" value="Submit" class="button">
                <a href="#" class="button">Back</a>
            </td>
        </tr>
    </table>

</form>