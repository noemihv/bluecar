'use strict'

jQuery(document).ready(
  () => {
    // first, find the index where the 'add new' btn should start making divs visible.
    let idx = findLatestVisibleDivIdx()

    jQuery('#add-color-btn').click(function (e) {
      e.preventDefault()
      makeDivVisible(idx + 1)
      idx++
      if (idx === 9) makeAddBtnInvisible()
    })

    jQuery('.delete-color-btn').click(function (e) {
      e.preventDefault()
      let idxToDelete = $(this).attr('id')
      console.log('idxToDelete: ', idxToDelete)
      console.log(JSON.stringify(getContentFromDiv(idxToDelete)))
      moveColorsDown(idxToDelete, idx)
      if (idx > 0) idx--
      makeAddBtnVisible()
    })
  }
)

function makeAddBtnVisible () {
  jQuery('#add-color-btn').prop('disabled', false)
}

function makeAddBtnInvisible () {
  jQuery('#add-color-btn').prop('disabled', true)
}

function makeDivVisible (idx) {
  jQuery('#bikini-color' + idx + '-div').css('display', 'block')
}

function makeDivInvisible (idx) {
  jQuery('#bikini-color' + idx + '-div').css('display', 'none')
}

function findLatestVisibleDivIdx () {
  for (let i = 0; i < 10; i++) {
    if (jQuery('#bikini-color' + i + '-div').css('display') === 'none') {
      return i - 1
    }
  }
}

function getContentFromDiv (idx) {
  let colorName = jQuery('#color' + idx + '_name').val()
  let colorHexa = jQuery('#color' + idx + '_hexa').val()
  let colorSizes = jQuery('#color' + idx + '_sizes').val()
  let colorInventory = jQuery('#color' + idx + '_inventory').val()
  let colorImage = jQuery('#color' + idx + '_image').val()

  return {
    colorName,
    colorHexa,
    colorSizes,
    colorInventory,
    colorImage
  }
}

function setContentOnDiv (idx, info) {
  jQuery('#color' + idx + '_name').val(info.colorName)
  jQuery('#color' + idx + '_hexa').val(info.colorHexa)
  jQuery('#color' + idx + '_sizes').val(info.colorSizes)
  jQuery('#color' + idx + '_inventory').val(info.colorInventory)
  jQuery('#color' + idx + '_image').val(info.colorImage)
}

function moveColorsDown (start, end) {
  let startAsNum = parseInt(start)
  let endAsNum = parseInt(end)
  let emptyInfo = {
    colorName: '',
    colorHexa: '',
    colorSizes: '',
    colorInventory: '',
    colorImage: ''
  }
  console.log('start: ', start, ', end: ', end)
  if (endAsNum === 0) { // means that the deleted color is the only one
    setContentOnDiv(end, emptyInfo)
  } else if (startAsNum === endAsNum) { // means that the deleted color was the last one.
    console.log('will delete last color')
    setContentOnDiv(start, emptyInfo)
    makeDivInvisible(start)
  } else { // means that the deleted color is in between.
    let idxCnt = startAsNum
    while (idxCnt < endAsNum) {
      let info = getContentFromDiv(idxCnt + 1)
      setContentOnDiv(idxCnt, info)
      idxCnt++
      console.log('cur idxCnt: ', idxCnt)
    }

    // finally empty the info on last color, and make the div invisible
    setContentOnDiv(end, emptyInfo)
    makeDivInvisible(end)
  }
}
