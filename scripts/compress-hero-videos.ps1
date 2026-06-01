# Compress homepage hero videos (dark + light). Requires ffmpeg in PATH.
$ErrorActionPreference = 'Stop'
$dir = Join-Path $PSScriptRoot '..\database\media\video' | Resolve-Path

$jobs = @(
    @{ In = 'VideoProject1.mp4'; Out = 'VideoProject1.compressed.mp4' },
    @{ In = 'video2tem.mp4'; Out = 'video2tem.compressed.mp4' }
)

foreach ($job in $jobs) {
    $input = Join-Path $dir $job.In
    $output = Join-Path $dir $job.Out
    if (-not (Test-Path $input)) { Write-Warning "Skip missing: $input"; continue }
    Write-Host "Encoding $($job.In)..."
    ffmpeg -y -i $input -vf scale=-2:720 -c:v libx264 -preset medium -crf 28 -an -movflags +faststart $output
}

Write-Host "Done. Replace originals manually after checking quality."
