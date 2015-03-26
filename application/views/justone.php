<div style="padding:50px; padding-top:10px;">
    <div class="row">
        <h3>{order} for {customer} ({order-type})</h3>
        <b>Special Instructions: <i>{special}</i></b>
        <hr>
        {burgers}
        <b>*Burger #{count}*</b>
        <br/>
        <br/>
        <ul>
            <li>Base: {patty}</li>
            {cheeseList}
            <li>Topping(s): {toppingList}</li>
            <li>Sauce(s): {sauceList}</li>
            {instructions}
            <br/>
            <b>Burger total: ${total}</b>
        </ul>
        {/burgers}
        <hr>
        <b>Order total: ${total}</b>
    </div>
</div>