<?php
/**
 * Created by PhpStorm.
 * User: wout
 * Date: 27.09.14
 * Time: 14:51
 */

namespace Zwaldeck;


/**
 * Class TmpClass
 * @package Zwaldeck
 *
 * @Entity
 */
class TmpClass {

    /**
     * @Column(name="id")
     * @Ignore
     */
    private $name;

    /**
     * @id
     * @Column(name="id")
     */
    private $id;

    /**
     * @preSave
     * @preSaveMethod(name=preSave, param1=p1, param2=p2)
     */
    public function preSave() {

    }
}
