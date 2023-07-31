<main class="col-10 p-3 ms-auto">
    <section class="countainer">
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-striped caption-top shadow"> 
                    <thead class="table-dark"> 
                        <?php echo $header;?>
                    </thead> 

                    <tbody>
                        <?php  echo $list;?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <td class="border-0" colspan="100%">
                                <div class="input-group">
                                    <?php echo $prev.$nav.$next.$limit; ?>
                                </div>
                            </td>
                        </tr>
                    </tfoot>

                    <caption>
                        <div class="px-2 fw-bold mb-3">
                            <?php echo $tabels; ?>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <form class="input-group col-4" action="<?php echo $url; ?>" method="GET">
                                    <input type="text" class="form-control" name="search" value="<?php echo $text ?>" placeholder="search">
                                    <button class="btn btn-primarry"><span class="fa-solid fa-magnifying-glass"></span></button>
                                </form>
                            </div>
                            <div class="col-8 text-end">
                                <?php echo $new; ?>  
                            </div>
                        </div>
                    </caption>
                </table>
            </div>
        </div>
    </section>
</main>