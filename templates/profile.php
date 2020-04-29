<div>
    <table>
        <tr>
            <th>Account amount</th>
            <td><?= $amount ?>$</td>
        </tr>
    </table>

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
            <input type="submit" value="Withdraw">
        </div>
    </form>
        </div>
