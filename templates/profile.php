<div>
    <table>
        <tr>
            <th>Account amount</th>
            <td><?= $amount ?>$</td>
        </tr>
        <tr>
            <th>Withdraw</th>
            <td>
                <form method="post">
                    <ul>
                        <?php foreach ($errors as $error): ?>
<li><?= $error ?></li>
                        <?php endforeach ?>
                    </ul>
                    <div>
                        <input
                                type="number"
                                min="0"
                                step="any"
                                name="withdraw"
                                value="<?= htmlspecialchars($withdraw) ?>">$
                    </div>
                    <div>
                        <input type="submit" value="Apply">
                    </div>
                </form>
            </td>
        </tr>
    </table>
</div>
