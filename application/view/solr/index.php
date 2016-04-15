<div class="container">
    <h2>Preencha os campos para adicionar um novo arquivo</h2>
    <!-- add song form -->
    <div class="box">
        <h3>Envio de arquivo</h3>
        <form action="<?php echo URL; ?>songs/addsong" method="POST">
            <p>
                <label>Artist</label>
                <input type="text" name="artist" value="" required />
            </p>
            <p>
                <label>Track</label>
                <input type="text" name="track" value="" required />
            </p>
            <label>Link</label>
            <input type="text" name="link" value="" />
            <input type="submit" name="submit_add_song" value="Submit" />
        </form>
    </div>
</div>
