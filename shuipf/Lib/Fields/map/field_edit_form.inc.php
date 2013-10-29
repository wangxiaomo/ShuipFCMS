<table cellpadding="2" cellspacing="1" width="98%">
    <tr> 
        <td>地图接口类型</td>
        <td>
            <input type="radio" onChange="mapclass_msg();" name="setting[mapclass]" value="1" <?php echo (int) $setting['mapclass'] == 1 ? 'checked' : '' ?> > 51地图 
            <input type="radio" onChange="mapclass_msg();" name="setting[mapclass]" value="2" <?php echo (int) $setting['mapclass'] == 2 ? 'checked' : '' ?> > 图吧地图 
            <input type="radio" onChange="mapclass_msg();" name="setting[mapclass]" value="3" <?php echo (int) $setting['mapclass'] == 3 ? 'checked' : '' ?> > 百度地图 
            <input type="radio" onChange="mapclass_msg();" name="setting[mapclass]" value="0" <?php echo (int) $setting['mapclass'] ? '' : 'checked' ?> > google地图
        </td>
    </tr>
    <tr> 
        <td>默认X轴坐标</td>
        <td><input class="input" type="text" name="setting[mapx]" value="<?php echo $setting['mapx'] ?>" id="mapx" size="20"></td>
    </tr>
    <tr> 
        <td>默认Y轴坐标</td>
        <td><input class="input" type="text" name="setting[mapy]" value="<?php echo $setting['mapy'] ?>" id="mapy" size="20"></td>
    </tr>
    <tr> 
        <td>默认缩放比例</td>
        <td><input class="input" type="text" name="setting[mapz]" id="mapz" value="<?php echo $setting['mapz'] ?>" size="20"> </td>
    </tr>
</table>
<script type="text/javascript">
    function mapclass_msg() {
        var old_class =<?= $setting['mapclass'] ?>;
        var old_class = old_class ? old_class == 1 ? "51地图" : "图吧地图" : "google地图";
        alert("您好，由于不同的地图供应商，数据并不通用，改变地图接口类型将会导致以前存在的数据无法使用，请慎重选择！\n\n您先前默认的地图供应商为  " + old_class);
    }
</script>