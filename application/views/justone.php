<div style="padding:50px; padding-top:10px;">
    <div class="row">
        <h3>{order} for {customer} ({order-type})</h3>
        <b>Special Instructions: <i>{special}</i></b>
        <hr>
        <br/>
        {burgers}
        <b>*Burger #{count}*</b><i>{name}</i>
        <br/>
        <br/>
        <ul>
            <li>Base: {pattyBurger}</li>
            {cheeseList}
            <li>Topping(s): {toppingList}</li>
            <li>Sauce(s): {sauceList}</li>
            {instructions}
            <br/>
            <b>Burger total: ${total}</b>
        </ul>
        <br/>
        {/burgers}
        <hr>
        <b>Order total: ${total}</b>
        <br/>
        <br/>
        <a href="/welcome">Back</a>
    </div>
</div>