<?php
class Admin_Block_Replay_Comment extends Core_Block_Template
{
    protected $_arr = [];
    public function getTicket()
    {
        return Mage::getModel('replay/ticket')
            ->load($this->getId())
            ->getTitle();
    }
    public function setfirstarr($id)
    {
        $this->_arr[0][] = $id;
    }
    public function getarr($val)
    {
        return Mage::getModel('replay/ticket_comment')
            ->getCollection()
            ->addFieldToFilter('ticket_id', $this->getId())
            ->addFieldToFilter('comment_id', $val)
            ->getData()[0];
    }
    function getMinimulLevel()
    {
        $ids = [];
        $minimum = $this->getComments()
            ->select(['minimum' => "MIN(level)"])
            ->getFirstItem()
            ->getMinimum();
        // Mage::log($minimum);
        $comments = $this->getComments()
            ->addFieldToFilter('level', $minimum)
            ->getData();
        foreach ($comments as $comment) {
            array_push($ids, $comment->getCommentId());
        }
        return $ids;
    }
    public function getId()
    {
        return $this->getRequest()->getQuery('ticket_id');
    }
    public function getshow()
    {
        return $this->getRequest()->getQuery('show');
    }
    public function getMaxLevel()
    {
        return Mage::getModel('replay/ticket_comment')
            ->getCollection()
            ->addFieldToFilter('ticket_id', $this->getId())
            ->select(['maximum' => 'MAX(level)'])
            ->getFirstItem()
            ->getMaximum();
    }
    public function getComments()
    {
        $limit = $this->getRequest()->getQuery('limit');
        $comments = Mage::getModel('replay/ticket_comment')
            ->getCollection()
            ->addFieldToFilter('ticket_id', $this->getId());
        if ($limit != '') {
            $max = $this->getMaxLevel();
            $comments->addFieldToFilter('level', ['>' => $max - $limit]);
        }
        if ($this->getshow() == "") {
            return $comments
                ->addFieldToFilter('is_active', 1);
        } else {
            return $comments;
        }
    }
    public function dataArray($id)
    {

        $data = $this->getComments()
            ->addFieldToFilter('parent_id', $id)
            ->getData();

        if (!$data) {
            $this->_arr[$id] = [];
            return;
        }
        foreach ($data as $d) {
            $this->_arr[$id][] = $d->getCommentId();
            $this->dataArray($d->getCommentId());
        }
        return $this->_arr;
    }
    function buildTree($tableArray, $parentId = 0)
    {
        $tree = [];
        if (isset($tableArray[$parentId])) {
            foreach ($tableArray[$parentId] as $id) {
                $node = [
                    'id' => $id,
                    'children' => $this->buildTree($tableArray, $id)
                ];
                $tree[] = $node;
            }
        }
        return $tree;
    }
    function render($tree, $ticket)
    {
        $rows = [];
        $rowspans = [];
        $this->getPaths($tree, [], $rows, $rowspans);
        $html = '';
        if (!empty($rows)) {
            if (!empty($rowspans)) {
                $last = max(array_keys($rowspans)) + 1;
            } else {
                $last = 0;
            }
            $totalRows = count($rows);

            $html = '<table border="1" cellpadding="10">';
            $html .= '<tr>';
            $html .= '<td rowspan="' . $totalRows . '">';
            $html .= $ticket;
            $html .= '<span hidden>NULL</span>';
            $html .= '</td>';
            foreach ($rows[0] as $key => $val) {
                $span = isset($rowspans[$key][$val]) ? $rowspans[$key][$val] : 1;
                if (!$this->getarr($val)->getIsActive()) {
                    $html .= '<td class="bg-success" rowspan="' . $span . '">' . $this->getarr($val)->getComment();
                } else {
                    $html .= '<td rowspan="' . $span . '">' . $this->getarr($val)->getComment();
                    $html .= '<span hidden>' . $val . '</span>';
                    if ($key == $last) {
                        $html .= "<button onclick='complited(this)'>complited</button>";
                    }
                    $html .= '</td>';
                    if ($key == $last) {
                        $html .= '<td><button onclick="openTextbox()">add comment</button><br></td>';
                    }
                }

                $printed[$key][$val] = true;
            }
            $html .= '</tr>';

            for ($i = 1; $i < $totalRows; $i++) {
                $html .= '<tr>';
                foreach ($rows[$i] as $key => $val) {
                    if (!isset($printed[$key][$val])) {
                        $span = isset($rowspans[$key][$val]) ? $rowspans[$key][$val] : 1;
                        if (!$this->getarr($val)->getIsActive()) {
                            $html .= '<td class="bg-success" rowspan="' . $span . '">' . $this->getarr($val)->getComment();
                        } else {
                            $html .= '<td rowspan="' . $span . '">' . $this->getarr($val)->getComment();
                        }
                        $html .= '<span hidden>' . $val . '</span>';
                        if ($key == $last) {
                            $html .= "<button onclick='complited(this)'>complited</button>";
                        }
                        $html .= '</td>';
                        if ($key == $last) {
                            $html .= '<td><button onclick="openTextbox()">add comment</button><br></td>';
                        }

                        $printed[$key][$val] = true;
                    }
                }
                $html .= '</tr>';
            }

            $html .= '</table>';
        } else {
            $html .= '<table>';
            $html .= '<tr>';
            $html .= "<td>{$ticket}<span hidden>NULL</span></td>";
            $html .= "<td><button onclick='openTextbox()'>add comment</button><br>";
            $html .= '</tr>';
            $html .= '</table>';
        }
        return $html;
    }
    function getPaths($tree, $path = [], &$rows = [], &$rowspans = [])
    {
        foreach ($tree as $t) {
            $currpath = array_merge($path, [$t['id']]);
            if (empty($t['children'])) {
                $rows[] = $currpath;
            } else {
                $countBefore = count($rows);
                $this->getPaths($t['children'], $currpath, $rows, $rowspans);
                $temp = count($rows) - $countBefore;
                $level = count($path);
                $rowspans[$level][$t['id']] = $temp;
            }
        }
    }
}
