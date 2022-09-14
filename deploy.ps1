New-Variable -Name DocumentRoot -Value C:\xampp\htdocs -Option Constant
Set-Alias -Name Execute-PHP -Value C:\xampp\php\php.exe -Option Constant

if (!(Test-Path $DocumentRoot -PathType Container)) {
  Write-Host 'Something is wrong with the document root.'
  Write-Host 'Fail.'
  exit 1
}

foreach ($file in gci htdocs) {
  $target = Join-Path $DocumentRoot (Split-Path -Leaf $file)
  if (Test-Path $target) {
    ri $target -Recurse
  }
  cpi $file $target -Recurse
}

Execute-PHP -r "require_once '$(Join-Path $DocumentRoot include model init.php)'; initialize_main();"
